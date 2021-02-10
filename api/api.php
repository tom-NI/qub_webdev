<?php
    // insert data and if it fails, print error message
    function dbQueryAndCheck($sqlQuery) {
        include("../dbconn.php");
        $insertedValue = $conn->query($sqlQuery);
        if (!$insertedValue) {
            echo $conn->error;
            die();
        }
    }

    function buildJSONresponse($sqlQuery) {
        $queryData = dbQueryAndCheck($sqlQuery);
        $fullDataSet = array();
        while ($row = $queryData->fetch_assoc()) {
            $match = array(
                "key" => $row["columnname"],
            );
            $fullDataSet[] = $match;
        }
        echo json_encode($fullDataSet);
    }
    
    if (!isset($_GET['fulldb'])) {
        echo "<p>no data provided</p>";
    } else {
        
        header('Content-Type: application/json');

        if (isset($_GET['ref_query'])) {
            // all referees query
            $refereeNameQuery = "SELECT RefereeName FROM `epl_referees` ORDER BY RefereeName ASC;";
            $refereeQueryData = dbQueryAndCheck($refereeNameQuery);
            $refereeDataSet = array();

            while ($row = $refereeQueryData->fetch_assoc()) {
                $ref = array(
                    "referee" => $row["RefereeName"],
                );
                $refereeDataSet[] = $ref;
            }
            echo json_encode($fullDataSet);
        } 
        if (isset($_GET['current_season'])) {
            // most recent season query from the API
            $currentSeason = "SELECT SeasonYears FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
            $currentSeasonQueryData = dbQueryAndCheck($currentSeason);
            $currentSeasonDataSet = array();

            while ($row = $currentSeasonQueryData->fetch_assoc()) {
                $season = array(
                    "currentSeason" => $row["SeasonYears"],
                );
                $currentSeasonDataSet[] = $season;
            }
            echo json_encode($fullDataSet);
        } 
        if (isset($_GET['current_seasons_clubs'])) {
            // query all current clubs from current season
            $currentSeasonID = "SELECT SeasonID FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
    
            $clubNameQuery = "SELECT DISTINCT epl_clubs.ClubName FROM `epl_clubs` 
            INNER JOIN epl_matches ON epl_matches.HomeClubID = epl_clubs.ClubID
            INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
            WHERE epl_seasons.SeasonID = {$currentSeasonID} ORDER BY ClubName ASC;";    
        }
    }
?>