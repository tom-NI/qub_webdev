<?php
    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin") {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            require(__DIR__ . "/../logic_files/allfunctions.php");
            require(__DIR__ . "/../logic_files/dbconn.php");

            // setup result string now to show result of operation to user.
            $submissionDisplayToUser = "";

            if (isset($_POST['change_ref'])) {
                $refereeToChange = htmlentities(trim($_POST['select_ref']));
                $newRefereeName = htmlentities(trim($_POST['new_ref_name']));
                $dataToSend = http_build_query(
                    array(
                        'ref_to_change' => $refereeToChange,
                        'new_ref_name' => $newRefereeName
                    )
                );
                $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/referees/?edit";
                $apiReply = postDevKeyWithData($endpoint, $dataToSend);

                if (http_response_code(200)) {
                    $submissionDisplayToUser = "Referee Name Changed";
                } else {
                    $apiJSON = json_decode($apiReply, true);
                    $submissionDisplayToUser = $apiJSON[0]["reply_message"];
                }
            } elseif (isset($_POST['change_club'])) {
                $clubToChange = htmlentities(trim($_POST['select_club']));
                $newClubName = htmlentities(trim($_POST['new_club_name']));
                $dataToSend = http_build_query(
                    array(
                        'club_to_change' => $clubToChange,
                        'new_club_name' => $newClubName
                    )
                );
                $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs/?edit";
                $apiReply = postDevKeyWithData($endpoint, $dataToSend);

                if (http_response_code(200)) {
                    $submissionDisplayToUser = "Club Name Changed";
                } else {
                    $submissionDisplayToUser = "Something went wrong, please try again";
                }
            } elseif (isset($_POST['delete_club'])) {
                $clubToDelete = htmlentities(trim($_POST['select_delete_club']));
                $finalClubName = removeUnderScores($clubToDelete);
                
                // check if any home or away team has a record against this club pre deletion?
                $stmt = $conn->prepare("SELECT HomeClubName FROM epl_home_team_stats WHERE HomeClubName = ? ");
                $stmt -> bind_param("s", $finalClubName);
                $stmt -> execute();
                $stmt -> store_result();
                
                // check the clubs total away records!
                $awayStmt = $conn->prepare("SELECT AwayClubName FROM epl_away_team_stats WHERE AwayClubName = ? ");
                $awayStmt -> bind_param("s", $finalClubName);
                $awayStmt -> execute();
                $awayStmt -> store_result();

                // check if the club is in the clubs table, but no matches associated with them!
                $disusedClubStmt = $conn->prepare("SELECT ClubID FROM epl_clubs WHERE epl_clubs.ClubName = ? ");
                $disusedClubStmt -> bind_param("s", $finalClubName);
                $disusedClubStmt -> execute();
                $disusedClubStmt -> store_result();

                $totalRows = (int) ($stmt->num_rows + $awayStmt->num_rows);
                $disusedClubCount = $disusedClubStmt->num_rows;
                $stmt -> close();
                $awayStmt -> close();

                if($totalRows > 0) {
                    $submissionDisplayToUser = "{$clubToDelete} Football Club is part of {$totalRows} match records and cannot be deleted.";
                } elseif ($totalRows == 0 && $disusedClubCount > 0) {
                    // get the clubID first
                    $stmt = $conn->prepare("SELECT ClubID FROM epl_clubs WHERE ClubName = ? ");
                    $stmt -> bind_param("s", $finalClubName);
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($clubID);
                    $stmt -> fetch();
                    $totalRows = (int) $stmt->num_rows;

                    if ($totalRows == 0) {
                        $$submissionDisplayToUser = "Unknown club, please select a club from the database";
                    } else {
                        // final delete statement
                        $finalStmt = $conn->prepare("DELETE FROM `epl_clubs` WHERE `epl_clubs`.`ClubID` = ? ");
                        $finalStmt -> bind_param("i", $clubID);
                        $finalStmt -> execute();

                        if ($finalStmt) {
                            $submissionDisplayToUser = "Club successfully deleted.";
                        } else {
                            $submissionDisplayToUser = "Club has not been deleted, please try again later";
                        }
                    }
                }
            } elseif (isset($_POST['delete_ref'])) {
                // dont delete thru the API (means other users have less control over our data! 
                // Delete direct to DB!
                $refToDelete = htmlentities(trim($_POST['select_delete_ref']));
                $stmt = $conn->prepare("SELECT * FROM `epl_matches` WHERE RefereeName = ? ;");
                $stmt -> bind_param("s", $refToDelete);
                $stmt -> execute();
                $stmt -> store_result();
                $totalRows = (int) $stmt -> num_rows;
                $stmt -> close();

                if ($totalRows > 0) {
                    $submissionDisplayToUser = "Referee {$refToDelete} is part of {$totalRows} match records and cannot be deleted";
                } else {
                    $refCheckStmt = $conn->prepare("SELECT RefereeID FROM epl_referees WHERE RefereeName = ? ");
                    $refCheckStmt -> bind_param("s", $refToDelete);
                    $refCheckStmt -> execute();
                    $refCheckStmt -> store_result();
                    $refCheckStmt -> bind_result($refID);
                    $refCheckStmt -> fetch();
                    $refTotalRows = (int) $refCheckStmt->num_rows;

                    if ($refTotalRows == 0) {
                        $submissionDisplayToUser = "Unknown referee, please select a referee who exists inside the database";
                    } else {
                        $finalStmt = $conn->prepare("DELETE FROM `epl_referees` WHERE `epl_referees`.`RefereeID` = ? ;");
                        $finalStmt -> bind_param("i", $refID);
                        $finalStmt -> execute();

                        if ($finalStmt) {
                            $submissionDisplayToUser = "Referee deleted.";
                        } else {
                            $submissionDisplayToUser = "Referee has not been deleted, please try again later";
                        }
                    }
                }
            } elseif (isset($_POST['delete_season'])) {
                $seasonToDelete = htmlentities(trim($_POST['delete_season_select']));    
                $stmt = $conn->prepare("SELECT * FROM `epl_matches` WHERE SeasonYears = ? ;");
                $stmt -> bind_param("s", $seasonToDelete);
                $stmt -> execute();
                $stmt -> store_result();

                $totalRows = (int) $stmt -> num_rows;
                $stmt -> close();

                if ($totalRows > 0) {
                    $submissionDisplayToUser = "Season {$seasonToDelete} is part of {$totalRows} match records, and cannot be deleted.";
                } else {
                    $stmt = $conn->prepare("SELECT SeasonID FROM epl_seasons WHERE SeasonYears = ? ");
                    $stmt -> bind_param("s", $seasonToDelete);
                    $stmt -> execute();
                    $stmt -> store_result();
                    $stmt -> bind_result($seasonID);
                    $stmt -> fetch();
                    $totalRows = (int) $stmt->num_rows;

                    if ($totalRows == 0) {
                        $submissionDisplayToUser = "Unknown or non-existent season, please enter season years in the format YYYY-YYYY.";
                    } else {
                        $finalStmt = $conn->prepare("DELETE FROM `epl_seasons` WHERE `epl_seasons`.`SeasonID` = ? ;");
                        $finalStmt -> bind_param("i", $seasonID);
                        $finalStmt -> execute();

                        if ($finalStmt) {
                            $submissionDisplayToUser = "Season successfully deleted.";
                        } else {
                            $submissionDisplayToUser = "Season has not been deleted, please try again later";
                        }
                    }
                }
            } elseif (isset($_POST['create_new_admin_btn'])) {
                $adminFirstName = htmlentities(trim($_POST['admin_register_firstname']));
                $adminSurname = htmlentities(trim($_POST['admin_register_surname']));
                $adminEmail = htmlentities(trim($_POST['admin_register_email']));
                $adminPassword1 = htmlentities(trim($_POST['admin_register_pw1']));
                $adminPassword2 = htmlentities(trim($_POST['admin_register_pw2']));
    
                if ($adminPassword1 !== $adminPassword2) {
                    $submissionDisplayToUser = "Passwords Dont Match, please try again";
                } else {
                    // check user doesnt already exist first!
                    $stmt = $conn->prepare("SELECT AdminID FROM `epl_admins` WHERE AdminEmail = ? ;");
                    $stmt -> bind_param("s", $adminEmail);
                    $stmt -> execute();
                    $stmt -> store_result();
                    if ($stmt->num_rows < 1) {
                        $securePassword = password_hash($adminPassword1, PASSWORD_DEFAULT);
                                                
                        $stmt = $conn->prepare("INSERT INTO `epl_admins` (`AdminID`, `AdminName`, `AdminSurname`, `AdminEmail`, `Password`) VALUES (NULL, ?, ?, ?, ?);");
                        $stmt -> bind_param("ssss",
                                        $adminFirstName,
                                        $adminSurname,
                                        $adminEmail,
                                        $securePassword
                                    );
                        $stmt -> execute();
                        $stmt -> store_result();
    
                        if($stmt) {
                            $submissionDisplayToUser = "New Admin Created";
                        } else {
                            http_response_code(400);
                            $submissionDisplayToUser = "Admin creation failed, please try again";
                        }
                    } else {
                        $submissionDisplayToUser = "Account already exists.";
                    }
                } 
            } else {
                $submissionDisplayToUser = "Unknown Request";
            }
        }
    }
?>