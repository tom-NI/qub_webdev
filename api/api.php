<?php
    header('Content-Type: application/json');
    // query database and if it fails, print error message
    function dbQueryAndCheck($sqlQuery) {
        include("../dbconn.php");
        $queriedValue = $conn->query($sqlQuery);
        if (!$queriedValue) {
            echo $conn->error;
            die();
        } else {
            return $queriedValue;
        }
    }

    if (!isset($_GET['eplinfo'])) {
        echo "no data provided";
        die();
    } else {
        $urlinfo = $_GET["eplinfo"];
    }
    if ($urlinfo == "ref_list") {
        // all referees query
        $refereeNameQuery = "SELECT RefereeName FROM `epl_referees` ORDER BY RefereeName ASC;";
        $refereeQueryData = dbQueryAndCheck($refereeNameQuery);
        $refereeDataSet = array();

        while ($row = $refereeQueryData->fetch_assoc()) {
            $ref = array(
                "refereename" => $row["RefereeName"],
            );
            $refereeDataSet[] = $ref;
        }
        echo json_encode($refereeDataSet);
    } 
    if ($urlinfo == "current_season") {
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
        echo json_encode($currentSeasonDataSet);
    }
    if ($urlinfo == "clubs") {
        // query all current clubs from current season

        $currentSeasonIDquery = "SELECT SeasonID FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
        $currentSeasonIDData = dbQueryAndCheck($currentSeasonIDquery);
        while ($row = $currentSeasonIDData->fetch_assoc()) {
            $seasonID = $row["SeasonID"];
        }
        
        $clubNameQuery = "SELECT DISTINCT epl_clubs.ClubName FROM `epl_clubs` 
        INNER JOIN epl_matches ON epl_matches.HomeClubID = epl_clubs.ClubID
        INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
        WHERE epl_seasons.SeasonID = {$seasonID} ORDER BY ClubName ASC;";

        $clubQueryData = dbQueryAndCheck($clubNameQuery);
        $clubsDataSet = array();
        while ($row = $clubQueryData->fetch_assoc()) {
            $clubnames = array(
                "clubname" => $row["ClubName"],
            );
            $clubsDataSet[] = $clubnames;
        }
        echo json_encode($clubsDataSet);
    }
    if ($urlinfo == "match_summary") {      
        if (isset($_GET['season_year'])) {
            $seasonYear = $_GET["season_year"];
            $seasonIdQuery = "SELECT SeasonID FROM epl_seasons WHERE SeasonYears LIKE '%{$seasonYear}%' LIMIT 1 ";
            $seasonIdData = dbQueryAndCheck($seasonIdQuery);
            while ($row = $seasonIdData->fetch_assoc()) {
                $seasonID = $row['SeasonID'];
            }
            if ($seasonID == null) {
                $seasonID = 1021;
            }
        } else {
            $seasonID = 1021;
        }

        $matchSummaryQuery = "SELECT epl_matches.MatchID, epl_matches.MatchDate,
        epl_matches.HomeClubID, epl_home_team_stats.HTTotalGoals, epl_away_team_stats.ATTotalGoals, epl_matches.AwayClubID
        FROM epl_matches
        INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
        INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
        INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_matches.HomeClubID
        WHERE SeasonID = {$seasonID}
        ORDER BY MatchID ASC";

        $matchSummaryData = dbQueryAndCheck($matchSummaryQuery);
        $matchSummaryDataSet = array();
        while ($row = $matchSummaryData->fetch_assoc()) {
            $homeClubID = $row["HomeClubID"];
            $awayClubID = $row["AwayClubID"];

            $homeClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$homeClubID}";
            $awayClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$awayClubID}";

            $homeClubQuery = dbQueryAndCheck($homeClubNameQuery);
            $awayQueryValue = dbQueryAndCheck($awayClubNameQuery);
            $homeTeamName;
            $homeTeamURL;
            $awayTeamName;
            $awayTeamURL;

            while ($homeTeamRow = $homeClubQuery->fetch_assoc()) {
                $homeTeamName = $homeTeamRow["ClubName"];
                $homeTeamURL = $homeTeamRow["ClubLogoURL"];
            }

            while ($awayTeamRow = $awayQueryValue->fetch_assoc()) {
                $awayTeamName = $awayTeamRow["ClubName"];
                $awayTeamURL = $awayTeamRow["ClubLogoURL"];
            }

            $matches = array(
                "matchdate" => $row["MatchDate"],
                "hometeam" => $homeTeamName,
                "homescore" => $row["HTTotalGoals"],
                "awayscore" => $row["ATTotalGoals"],
                "awayteam" => $awayTeamName,
                "hometeamlogoURL" => $homeTeamURL,
                "awayteamlogoURL" => $awayTeamURL
            );
            $matchSummaryDataSet[] = $matches;
        }
        echo json_encode($matchSummaryDataSet);
    }
?>