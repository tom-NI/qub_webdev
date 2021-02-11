<?php
    header('Content-Type: application/json');
    require("../allfunctions.php");
    // query database and if it fails, print error message

    // TODO - test this works and produces 
    function clubsNamesAndURLSQuery($homeID, $awayID) {
        $homeClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$homeID}";
        $awayClubNameQuery = "SELECT epl_clubs.ClubName, epl_clubs.ClubLogoURL FROM `epl_clubs` WHERE ClubID = {$awayID}";

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
    }
    // the final dataset that any query will build (to be encoded into JSON)
    $finalDataSet = array();

    // if (!isset($_GET['list']) || !isset($_GET['matches'])) {
    //     echo "no lists here! Sorry";
    //     die();
    // } else
    if (isset($_GET['list'])) {
        // get the value
        $listValue = $_GET["list"];
        // mod the return info based on key!
        if ($listValue == "ref_list") {
            // all referees query
            $refereeNameQuery = "SELECT RefereeName FROM `epl_referees` ORDER BY RefereeName ASC;";
            $refereeQueryData = dbQueryCheckReturn($refereeNameQuery);
            while ($row = $refereeQueryData->fetch_assoc()) {
                $ref = array(
                    "refereename" => $row["RefereeName"],
                );
                $finalDataSet[] = $ref;
            }
        } 
        if ($listValue == "current_season") {
            // most recent season query from the API
            $currentSeason = "SELECT SeasonYears FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
            $currentSeasonQueryData = dbQueryCheckReturn($currentSeason);
            while ($row = $currentSeasonQueryData->fetch_assoc()) {
                $season = array(
                    "currentSeason" => $row["SeasonYears"],
                );
                $finalDataSet[] = $season;
            }
        }
        if ($listValue == "current_season_clubs") {
            // query all current clubs from current season
    
            $currentSeasonIDquery = "SELECT SeasonID FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
            $currentSeasonIDData = dbQueryCheckReturn($currentSeasonIDquery);
            while ($row = $currentSeasonIDData->fetch_assoc()) {
                $seasonID = $row["SeasonID"];
            }
            
            $clubNameQuery = "SELECT DISTINCT epl_clubs.ClubName FROM `epl_clubs` 
            INNER JOIN epl_matches ON epl_matches.HomeClubID = epl_clubs.ClubID
            INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
            WHERE epl_seasons.SeasonID = {$seasonID} ORDER BY ClubName ASC;";
    
            $clubQueryData = dbQueryCheckReturn($clubNameQuery);
            while ($row = $clubQueryData->fetch_assoc()) {
                $clubnames = array(
                    "clubname" => $row["ClubName"],
                );
                $finalDataSet[] = $clubnames;
            }
        }
    } elseif (isset($_GET['matches'])) {
        $matchValue = $_GET['matches'];

        if ($matchValue == "match_summary") { 
            $seasonID = null;
            $finalCount = null;
            if (isset($_GET['season'])) {
                $seasonYear = $_GET["season"];
                $seasonIdQuery = "SELECT SeasonID FROM epl_seasons WHERE SeasonYears LIKE '%{$seasonYear}%' LIMIT 1 ";
                $seasonIdData = dbQueryCheckReturn($seasonIdQuery);
                while ($row = $seasonIdData->fetch_assoc()) {
                    $seasonID = $row['SeasonID'];
                }
                if ($seasonID == null) {
                    $seasonID = 1021;
                }
            } else {
                $seasonID = 1021;
            }

            $mainQuery = "SELECT epl_matches.MatchID, epl_matches.MatchDate,
            epl_matches.HomeClubID, epl_home_team_stats.HTTotalGoals, epl_away_team_stats.ATTotalGoals, epl_matches.AwayClubID
            FROM epl_matches
            INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
            INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
            INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_matches.HomeClubID
            WHERE SeasonID = {$seasonID}
            ORDER BY MatchID ASC";

            $matchSummaryQuery = $mainQuery;

            if (isset($_GET['count'])) {
                $matchCount = (int) $_GET['count'];
                if ($matchCount != 0 && $matchCount != null) {
                    $limitQuery = "LIMIT {$matchCount}";
                    $matchSummaryQuery = "{$mainQuery} {$limitQuery}";
                }
            } else {
                $matchSummaryQuery = $mainQuery;
            }
    
            $matchSummaryData = dbQueryCheckReturn($matchSummaryQuery);
            while ($row = $matchSummaryData->fetch_assoc()) {
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
    
                $matches = array(
                    "matchdate" => $row["MatchDate"],
                    "hometeam" => $homeTeamName,
                    "homescore" => $row["HTTotalGoals"],
                    "awayscore" => $row["ATTotalGoals"],
                    "awayteam" => $awayTeamName,
                    "hometeamlogoURL" => $homeTeamURL,
                    "awayteamlogoURL" => $awayTeamURL
                );
                $finalDataSet[] = $matches;
            }
        }
    } elseif (isset($_GET['fixture'])) {
        // 1 fixture : (man u v west ham!) - all records for stats analysis!
        $fixtureValue = $_GET['fixture'];

        // split the value into two teams with the hashtag delimiter and remove underscores
        // team names exposed in API to make the API general purpose for users, who wouldnt know clubID
        trim($fixtureValue);
        $newFixtureValue = removeUnderScores($fixtureValue);
        $fixtureValueArray = explode("~", $newFixtureValue);
        $homeTeamNameSearch = $fixtureValueArray[0];
        $awayTeamNameSearch = $fixtureValueArray[1];

        if ($homeTeamNameSearch != null && $awayTeamNameSearch != null) {
            $homeClubQuery = "SELECT ClubID, ClubName FROM `epl_clubs` WHERE ClubName LIKE '%{$homeTeamNameSearch}%';";
            $awayClubQuery = "SELECT ClubID, ClubName FROM `epl_clubs` WHERE ClubName LIKE '%{$awayTeamNameSearch}%';";

            $homeClubValue = dbQueryCheckReturn($homeClubQuery);
            $awayClubValue = dbQueryCheckReturn($awayClubQuery);

            if (mysqli_num_rows($homeClubValue) != 0 && mysqli_num_rows($awayClubValue) != 0) {
                while ($homeTeamRow = $homeClubValue->fetch_assoc()) {
                    $homeTeamID = $homeTeamRow["ClubID"];
                    $homeTeamName = $homeTeamRow["ClubName"];
                }
                while ($awayTeamRow = $awayClubValue->fetch_assoc()) {
                    $awayTeamID = $awayTeamRow["ClubID"];
                    $awayTeamName = $awayTeamRow["ClubName"];
                }

                $fixtureQuery = "SELECT epl_home_team_stats.HTTotalGoals, 
                epl_home_team_stats.HTHalfTimeGoals, epl_home_team_stats.HTShots, epl_home_team_stats.HTShotsOnTarget, 
                epl_home_team_stats.HTCorners, epl_home_team_stats.HTFouls, epl_home_team_stats.HTYellowCards, 
                epl_home_team_stats.HTRedCards, epl_away_team_stats.ATTotalGoals, epl_away_team_stats.ATHalfTimeGoals, 
                epl_away_team_stats.ATShots, epl_away_team_stats.ATShotsOnTarget, epl_away_team_stats.ATCorners, 
                epl_away_team_stats.ATFouls, epl_away_team_stats.ATYellowCards, epl_away_team_stats.ATRedCards
                FROM epl_matches
                INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
                INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
                INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
                INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID
                INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_matches.HomeClubID
                WHERE epl_matches.HomeClubID = {$homeTeamID} AND
                epl_matches.AwayClubID = {$awayTeamID};";

                $fixtureQueryData = dbQueryCheckReturn($fixtureQuery);
                while ($row = $fixtureQueryData->fetch_assoc()) {
                    $fixture = array(
                        "hometeam" => $homeTeamName,
                        "awayteam" => $awayTeamName,
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
                    $finalDataSet[] = $fixture;
                }
            }
        }
    } elseif (isset($_GET['singlematch'])) {
        // singlematch - one match, all details - by match id
        $singleMatchID = $_GET['singlematch'];
        $checkIdQuery = "SELECT MatchID FROM epl_matches WHERE MatchID = {$singleMatchID} ";

        if (mysqli_num_rows($singleMatchData) > 0) {
            // TODO only half done
            $singleMatchQuery = "SELECT epl_matches.MatchDate, epl_matches.KickOffTime, epl_referees.RefereeName, epl_matches.HomeClubID, epl_matches.AwayClubID, epl_home_team_stats.HTTotalGoals, epl_home_team_stats.HTHalfTimeGoals, epl_home_team_stats.HTShots, epl_home_team_stats.HTShotsOnTarget, epl_home_team_stats.HTCorners, epl_home_team_stats.HTFouls, 
            epl_home_team_stats.HTYellowCards, epl_home_team_stats.HTRedCards, epl_away_team_stats.ATTotalGoals, 
            epl_away_team_stats.ATHalfTimeGoals, epl_away_team_stats.ATShots, epl_away_team_stats.ATShotsOnTarget, 
            epl_away_team_stats.ATCorners, epl_away_team_stats.ATFouls, epl_away_team_stats.ATYellowCards, epl_away_team_stats.ATRedCards
            FROM epl_matches
            INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
            INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
            INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
            INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID
            INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_matches.HomeClubID
            ORDER BY MatchID ASC;";

            $singleMatchData = dbQueryCheckReturn($singleMatchQuery);
            $finalDataSet = array();

            while ($row = $refereeQueryData->fetch_assoc()) {
                $fixture = array(
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
                $fixtureDataSet[] = $fixture;
            }
        }
    } elseif (isset($_GET['season'])) {
        // season = whatever!

    } elseif (isset($_GET['matchsummary'])) {
        // matchsummary = amount!
    }

    echo json_encode($finalDataSet);
?>