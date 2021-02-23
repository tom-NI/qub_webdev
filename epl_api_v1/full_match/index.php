<?php
    header('Content-Type: application/json');

    // api defines a seperate functions file to mimic a true seperate server!
    require("../apifunctions.php");

    require("../part_authenticate.php"); {
        $finalDataSet = array();
        
        // get FULL data from matches
        $mainMatchQuery = "SELECT epl_matches.MatchId, epl_matches.MatchDate, epl_matches.KickOffTime, epl_referees.RefereeName, 
        epl_home_team_stats.HomeClubID, epl_away_team_stats.AwayClubID, epl_home_team_stats.HTTotalGoals, epl_home_team_stats.HTHalfTimeGoals, 
        epl_home_team_stats.HTShots, epl_home_team_stats.HTShotsOnTarget, epl_home_team_stats.HTCorners, epl_home_team_stats.HTFouls, 
        epl_home_team_stats.HTYellowCards, epl_home_team_stats.HTRedCards, epl_away_team_stats.ATTotalGoals, 
        epl_away_team_stats.ATHalfTimeGoals, epl_away_team_stats.ATShots, epl_away_team_stats.ATShotsOnTarget, 
        epl_away_team_stats.ATCorners, epl_away_team_stats.ATFouls, epl_away_team_stats.ATYellowCards, epl_away_team_stats.ATRedCards
        FROM epl_matches
        INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
        INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
        INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
        INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID
        INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_home_team_stats.HomeClubID";

        $orderQuery = "ORDER BY MatchID ASC";

        if (isset($_GET['onematch'])) {
            // singlematch - return one match by match id
            $singleMatchID = (int) $_GET['onematch'];
    
            // check id exists in DB before proceeding!
            $checkIdQuery = "SELECT MatchID FROM epl_matches WHERE MatchID = {$singleMatchID} ";
            $matchIDData = dbQueryCheckReturn($checkIdQuery);
    
            if (mysqli_num_rows($matchIDData) > 0) {
                while ($row = $matchIDData->fetch_assoc()) {
                    $matchID = $row['MatchID'];
                }
                // get both clubIDs from the match in question!
                $clubIDQuery = "SELECT epl_home_team_stats.HomeClubID, epl_away_team_stats.AwayClubID 
                FROM epl_home_team_stats 
                INNER JOIN epl_away_team_stats ON epl_away_team_stats.MatchID = epl_home_team_stats.MatchID
                WHERE epl_away_team_stats.MatchID = 1000 && epl_home_team_stats.MatchID = {$matchID};";
                
                $clubIDData = dbQueryCheckReturn($clubIDQuery);
                while ($row = $clubIDData->fetch_assoc()) {
                    $homeClubID = $row['HomeClubID'];
                    $awayClubId = $row['AwayClubID'];
                }
                $conditionQuery = "WHERE epl_matches.MatchId = {$matchID}";
                $finalQuery = "{$mainMatchQuery} {$conditionQuery} {$orderQuery}";
            }
        } elseif (isset($_GET['fullseason'])) {
            // if the user requests a full seasons matches
            // first check the season input and check it exists within the DB before proceeding (incase user can change on client)
            // todo - do i need to real_escape_string here?
            $seasonYears = $_GET['fullseason'];
            $checkSeasonExistsQuery = "SELECT * FROM epl_seasons WHERE SeasonYears LIKE '%{$seasonYears}%' ";
            $seasonExistsData = dbQueryCheckReturn($checkSeasonExistsQuery);

            // only proceed if the season exists in the database
            if (mysqli_num_rows($seasonExistsData) > 0) {
                while ($row = $seasonExistsData->fetch_assoc()) {
                    $seasonID = $row['SeasonID'];
                }
                $conditionQuery = "WHERE epl_seasons.SeasonID = {$seasonID}";
                $finalQuery = "{$mainMatchQuery} {$conditionQuery} {$orderQuery}";
            } else {
                http_response_code(204);
                echo "no season found";
                die();
            }
        } elseif (isset($_GET['fixture'])) {
            // 1 fixture - get all records throughout history for stats analysis!
            $fixtureValue = $_GET['fixture'];

            // split the value into two teams with the hashtag delimiter and remove underscores
            // team names exposed in API to make the API general purpose for users, who wouldnt know clubID
            trim($fixtureValue);
            $newFixtureValue = removeUnderScores($fixtureValue);
            $fixtureValueArray = explode("~", $newFixtureValue);
            $homeTeamNameSearch = $fixtureValueArray[0];
            $awayTeamNameSearch = $fixtureValueArray[1];

            if (($homeTeamNameSearch != null) && (strlen($homeTeamNameSearch) > 0) 
                && ($awayTeamNameSearch != null) && (strlen($awayTeamNameSearch) > 0)) {
                $homeClubQuery = "SELECT ClubID FROM `epl_clubs` WHERE ClubName LIKE '%{$homeTeamNameSearch}%';";
                $awayClubQuery = "SELECT ClubID FROM `epl_clubs` WHERE ClubName LIKE '%{$awayTeamNameSearch}%';";

                $homeClubValue = dbQueryCheckReturn($homeClubQuery);
                $awayClubValue = dbQueryCheckReturn($awayClubQuery);

                if (mysqli_num_rows($homeClubValue) != 0 && mysqli_num_rows($awayClubValue) != 0) {
                    while ($homeTeamRow = $homeClubValue->fetch_assoc()) {
                        $homeTeamID = $homeTeamRow['ClubID'];
                    }
                    while ($awayTeamRow = $awayClubValue->fetch_assoc()) {
                        $awayTeamID = $awayTeamRow['ClubID'];
                    }

                    $defaultTeamQuery = "WHERE (epl_home_team_stats.HomeClubID = {$homeTeamID} AND epl_away_team_stats.AwayClubID = {$awayTeamID})
                    OR (epl_home_team_stats.HomeClubID = {$awayTeamID} AND epl_away_team_stats.AwayClubID = {$homeTeamID})";

                    if (isset($_GET['strict'])) {
                        $teamQuery = "WHERE epl_home_team_stats.HomeClubID = {$homeTeamID} AND epl_away_team_stats.AwayClubID = {$awayTeamID}";
                    } else {
                        $teamQuery = $defaultTeamQuery;
                    }
                    
                    if (isset($_GET['count'])) {
                        $limitQuery = queryPagination();
                    } else {
                        $limitQuery = "";
                    }

                    $finalQuery = "{$mainMatchQuery} {$teamQuery} {$orderQuery} {$limitQuery}";
                } else {
                    http_response_code(204);
                    die();
                }
            }
        } else {
            http_response_code(404);
            die();
        }

        $matchData = dbQueryCheckReturn($finalQuery);

        // get club names and logo URLS from the database
        while ($row = $matchData->fetch_assoc()) {
            $homeClubID = $row["HomeClubID"];
            $awayClubID = $row["AwayClubID"];

            $homeClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$homeClubID}";
            $awayClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$awayClubID}";

            $homeClubValue = dbQueryCheckReturn($homeClubNameQuery);
            $awayClubValue = dbQueryCheckReturn($awayClubNameQuery);
            $homeTeamName;
            $homeTeamURL;
            $awayTeamName;
            $awayTeamURL;

            while ($homeTeamRow = $homeClubValue->fetch_assoc()) {
                $homeTeamName = $homeTeamRow["ClubName"];
                $homeTeamURL = $homeTeamRow["ClubLogoURL"];
            }

            while ($awayTeamRow = $awayClubValue->fetch_assoc()) {
                $awayTeamName = $awayTeamRow["ClubName"];
                $awayTeamURL = $awayTeamRow["ClubLogoURL"];
            }
            
            $singlematch = array(
                "matchdate" => $row["MatchDate"],
                "kickofftime" => $row["KickOffTime"],
                "refereename" => $row["RefereeName"],
                "hometeam" => $homeTeamName,
                "awayteam" => $awayTeamName,
                "hometeamlogoURL" => $homeTeamURL,
                "awayteamlogoURL" => $awayTeamURL,
                "hometeamtotalgoals" => $row["HTTotalGoals"],
                "hometeamhalftimegoals" => $row["HTHalfTimeGoals"],
                "hometeamshots" => $row["HTShots"],
                "hometeamshotsontarget" => $row["HTShotsOnTarget"],
                "hometeamcorners" => $row["HTCorners"],
                "hometeamfouls" => $row["HTFouls"],
                "hometeamyellowcards" => $row["HTYellowCards"],
                "hometeamredcards" => $row["HTRedCards"],
                "awayteamtotalgoals" => $row["ATTotalGoals"],
                "awayteamhalftimegoals" => $row["ATHalfTimeGoals"],
                "awayteamshots" => $row["ATShots"],
                "awayteamshotsontarget" => $row["ATShotsOnTarget"],
                "awayteamcorners" => $row["ATCorners"],
                "awayteamfouls" => $row["ATFouls"],
                "awayteamyellowcards" => $row["ATYellowCards"],
                "awayteamredcards" => $row["ATRedCards"]
            );
            $finalDataSet[] = $singlematch;
        }

        // encode the final data set to JSON
        echo json_encode($finalDataSet); 
    }
?>