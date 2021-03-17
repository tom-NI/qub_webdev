<?php
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    require(__DIR__ . "/../logic_files/dbconn.php");
    if (isset($_GET['deletematch'])) {
        $matchID = (int) htmlentities(trim($_GET['id']));

        // get refereeID first
        $stmt = $conn->prepare("SELECT MatchID FROM `epl_matches` WHERE MatchID = ? ");
        $stmt -> bind_param("i", $matchID);
        $stmt -> execute();
        $stmt -> store_result();
        $totalRows = $stmt->num_rows;
        $stmt -> close();
        
        if ($totalRows === 1) {
            $homeStmt = $conn->prepare("DELETE FROM `epl_home_team_stats` WHERE `epl_home_team_stats`.`MatchID` = ? ;");
            $homeStmt -> bind_param("i", $matchID);
            $homeStmt -> execute();

            $awayStmt = $conn->prepare("DELETE FROM `epl_away_team_stats` WHERE `epl_away_team_stats`.`MatchID` = ? ;");
            $awayStmt -> bind_param("i", $matchID);
            $awayStmt -> execute();

            $matchStmt = $conn->prepare("DELETE FROM `epl_matches` WHERE `epl_matches`.`MatchID` = ? ;");
            $matchStmt -> bind_param("i", $matchID);
            $matchStmt -> execute();

            if ($homeStmt && $awayStmt && $matchStmt) {
                //  successful, therefore go to match search page
                header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_advanced_search.php");
                die();
            } else {
                http_response_code(500);
                header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_single_match_result.php?id={$matchID}");
            }
        } else {
            http_response_code(400);
            header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_single_match_result.php?id={$matchID}");
        }
    }
?>