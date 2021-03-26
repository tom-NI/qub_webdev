<?php
    session_start();
    // this file is a single match deletion logic only.

    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    require(__DIR__ . "/../logic_files/dbconn.php");
    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin") {
        require(__DIR__ . "/../logic_files/dbconn.php");
        if (isset($_GET['deletematch'])) {
            $matchID = (int) htmlentities(trim($_GET['num']));
            
            // get check match exists first to prevent any oddness
            $stmt = $conn->prepare("SELECT MatchID FROM `epl_matches` WHERE MatchID = ? ");
            $stmt -> bind_param("i", $matchID);
            $stmt -> execute();
            $stmt -> store_result();
            if ($stmt->num_rows === 1) {
                $stmt -> close();

                // get the user ID to insert into the DB
                $userID = $_SESSION['userid'];
                
                // record the user is making a deletion first!
                $currentDateTime = date("Y-m-d H:i:s");
                $justificationForChange = "Match Deleted";
                
                $editMatchStmt = $conn->prepare("INSERT INTO `epl_match_edits` (`EditID`, `MatchID`, `EditedByUserID`, `EditDescription`, `EditedDate`) VALUES (NULL, ?, ?, ?, ? ); ");
                $editMatchStmt -> bind_param("isss",
                        $matchID,
                        $userID,
                        $justificationForChange,
                        $currentDateTime
                );
                if ($editMatchStmt -> execute()) {
                    $conn->autocommit(false);
                    try {
                        $homeStmt = $conn->prepare("DELETE FROM `epl_home_team_stats` WHERE `epl_home_team_stats`.`MatchID` = ? ;");
                        $homeStmt -> bind_param("i", $matchID);
                        $homeStmt -> execute();
                        
                        $awayStmt = $conn->prepare("DELETE FROM `epl_away_team_stats` WHERE `epl_away_team_stats`.`MatchID` = ? ;");
                        $awayStmt -> bind_param("i", $matchID);
                        $awayStmt -> execute();
                        
                        $matchStmt = $conn->prepare("DELETE FROM `epl_matches` WHERE `epl_matches`.`MatchID` = ? ;");
                        $matchStmt -> bind_param("i", $matchID);
                        $matchStmt -> execute();

                        $conn->commit();
                        $conn->autocommit(true);
                        //  successful, therefore go to match search page
                        header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_advanced_search.php");
                    } catch (Exception $e) {
                        $conn->rollback();
                        $conn->autocommit(true);
                        // header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_single_match_result.php?num={$matchID}");
                    }
                } else {
                }
            } else {
                header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/index.php");
            }
        }
    }
?>