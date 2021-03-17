<?php
    session_start();
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
                $stmt = $conn->prepare("SELECT ClubID FROM epl_clubs INNER JOIN epl_home_team_stats ON epl_clubs.ClubID = epl_home_team_stats.HomeClubID where epl_clubs.ClubName = ? ");
                $stmt -> bind_param("s", $finalClubName);
                $stmt -> execute();
                $stmt -> store_result();
                
                // check the clubs total away records!
                $awayStmt = $conn->prepare("SELECT ClubID FROM epl_clubs INNER JOIN epl_away_team_stats ON epl_clubs.ClubID = epl_away_team_stats.AwayClubID WHERE epl_clubs.ClubName = ? ");
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
                $stmt = $conn->prepare("SELECT * FROM `epl_matches` INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID WHERE epl_referees.RefereeName = ? ;");
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
                $stmt = $conn->prepare("SELECT * FROM `epl_matches` INNER JOIN epl_seasons ON epl_seasons.SeasonID = epl_matches.SeasonID WHERE epl_seasons.SeasonYears = ? ;");
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
            } else {
                $submissionDisplayToUser = "Unknown Request";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../stylesheets/mystyles.css">
    <title>Edit a match result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php
        include("../part_pages/part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Manage Data:</h1>
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
        <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<div class='mt-5 p-5 has-background-warning'>
                    <div>
                        <h3 class='title is-5'>{$submissionDisplayToUser}</h3>
                        <p class='subtitle is-6 pt-3'>Please modify further data below.</p>
                    </div>
                </div>";
            }
        ?>
            <!-- EDIT CLUB AND REFEREE NAMES -->
            <div class="mt-5 p-5 my_info_colour p-3">
                <h2 class="title is-4 mb-2 my_info_colour">Edit Names</h2>
                <div class="my-4">
                    <form action="" method="POST" class="level">
                        <div class="select is-info my_medium_form_item">
                            <select required class="level-item my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class='my_medium_textinput_item level-item mx-2'>
                            <input required class="input" type="text" name="new_ref_name" placeholder="New Referee name">
                        </div>
                        <div class='my_medium_form_item level-item'>
                            <button name="change_ref" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Referee Name</button>
                        </div>
                    </form>
                </div>
                <div class="my-4">
                    <form action="" method="POST" class="level">
                        <div class="select is-info my_medium_form_item">
                            <select required class="level-item my_medium_form_item" name="select_club" id="edit_club_select">
                                <?php
                                    require("../part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class='my_medium_textinput_item level-item mx-2'>
                            <input required class="input" type="text" name="new_club_name" placeholder="New Club name">
                        </div>
                        <div class='my_medium_form_item level-item'>
                            <button name="change_club" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Club Name</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Referees or clubs -->
            <div class="mt-5 p-5 my_info_colour p-3">
                <h2 class="title is-4 mb-2 my_info_colour">Delete Data</h2>
                <p class='my-4'>Data cannot be deleted if it currently forms part of any match record</p>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info level-item">
                            <select required class="my_medium_form_item" name="select_delete_club" id="delete_club_select">
                                <?php
                                    require("../part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_club" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Club</button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="select_delete_ref" id="delete_ref_select">
                                <?php
                                    require("../part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_ref" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Referee</button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="delete_season_select" id="delete_season_select">
                                <?php
                                    require("../part_pages/part_season_select.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_season" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Season</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php include("../part_pages/part_site_footer.php"); ?>
    <script src="../scripts/my_script.js"></script>
</body>

</html>