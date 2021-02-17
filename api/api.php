<?php
    header('Content-Type: application/json');
    require("../allfunctions.php");

    // TODO 
    // MOVE ANY FUNCTIONS OVER TO FUNCTIONS FILE?
    // SECURE THE API for Create update delete?
    // WRITE API QUERIES TO UPDATE A MATCH, USING A TRANSACTION
    // FINISH THE !ISSET PART OF THE IF/ELSE TREE
    // UNDER MATCH_SUMMARY K:VALUE - SWITCH OUT THE CLUBNAMESANDURLQUERY FUNCTION
    // TODO - try to get a function written for getting club names and URLs
    // CHANGE AUTOINCREMENTS INSIDE THE SQL DATABASE?
    // TODO - UNDER THE "usersearch" branch, is the addUnderScores function in the correct place?
    // todo - where do i add the call to real_escape_string to prevent SQL injections?
    // secure the create, update and delete using a SESSION and security?

    // the final dataset object that EVERY read query will build (to be encoded into JSON)
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
        } elseif ($listValue == "current_season") {
            // get the current device calendar month and year to search for the current season.
            $getCurrentMonth = date("m");
            $getYear = date("Y");
            if ($getCurrentMonth < 07) {
                $firstYear = (int) $getYear - 1;
                $seasonSearch = "{$firstYear}-{$getYear}";
            } else {
                $secondYear = (int) $getYear + 1;
                $seasonSearch = "{$getYear}-{$secondYear}";
            }
            // the search to see if the current season exists in the DB
            $currentSeason = "SELECT SeasonYears FROM `epl_seasons` WHERE SeasonYears LIKE '%{$seasonSearch}%';";
            $currentSeasonQueryData = dbQueryCheckReturn($currentSeason);

            // todo - change to a single row query!
            while ($row = $currentSeasonQueryData->fetch_assoc()) {
                $season = array(
                    "currentSeason" => $row["SeasonYears"],
                );
                $finalDataSet[] = $season;
            }
        } elseif ($listValue == "current_season_clubs") {
            // query all current clubs from current season
            $currentSeasonIDquery = "SELECT SeasonID FROM `epl_seasons` ORDER BY SeasonID DESC LIMIT 1";
            $currentSeasonIDData = dbQueryCheckReturn($currentSeasonIDquery);
            while ($row = $currentSeasonIDData->fetch_assoc()) {
                $seasonID = $row["SeasonID"];
            }
            
            $clubNameQuery = "SELECT DISTINCT epl_clubs.ClubName FROM `epl_clubs` 
            INNER JOIN epl_home_team_stats ON epl_home_team_stats.HomeClubID = epl_clubs.ClubID
            INNER JOIN epl_away_team_stats ON epl_away_team_stats.AwayClubID = epl_clubs.ClubID
            INNER JOIN epl_matches ON epl_matches.MatchID = epl_home_team_stats.MatchID
            INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
            WHERE epl_seasons.SeasonID = {$seasonID} ORDER BY ClubName ASC;";
    
            $clubQueryData = dbQueryCheckReturn($clubNameQuery);
            while ($row = $clubQueryData->fetch_assoc()) {
                $clubnames = array(
                    "clubname" => $row["ClubName"],
                );
                $finalDataSet[] = $clubnames;
            }
        } elseif ($listValue == "all_seasons_list") {
            $seasonQuery = "SELECT SeasonYears FROM `epl_seasons` ORDER BY SeasonYears DESC;";
            $seasonQueryData = dbQueryCheckReturn($seasonQuery);
            while ($row = $seasonQueryData->fetch_assoc()) {
                $season = array(
                    "season" => $row["SeasonYears"],
                );
                $finalDataSet[] = $season;
            }
        }
    } elseif (isset($_GET['match_summaries'])) {
            $seasonID = null;
            $finalCount = null;

            $mainQuery = "SELECT epl_matches.MatchID, epl_matches.MatchDate,
            epl_home_team_stats.HomeClubID, epl_home_team_stats.HTTotalGoals, epl_away_team_stats.ATTotalGoals, epl_away_team_stats.AwayClubID
            FROM epl_matches
            INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
            INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID";

            $orderByQuery = "ORDER BY epl_matches.MatchID DESC";

            if (isset($_GET['season'])) {
                $seasonYear = $_GET["season"];
                
                // only proceed with the query if the input matches regex constraints
                if (checkSeasonRegex($seasonYear)) {
                    $seasonIdQuery = "SELECT SeasonID FROM epl_seasons WHERE SeasonYears LIKE '%{$seasonYear}%' LIMIT 1";
                    $seasonIdData = dbQueryCheckReturn($seasonIdQuery);
                    if (mysqli_num_rows($seasonIdData) == 0) {
                        $seasonID = 30;
                        echo "No Data for that Season";
                    } else {
                        $row = $seasonIdData->fetch_row();
                        $seasonID = $row[0];
                    }
                    $seasonQuery = "WHERE SeasonID = {$seasonID}";
                } else {
                    echo "Please enter a season value in the format YYYY-YYYY";
                }
            } else {
                // TODO - fetch current season itself!
                // $currentSeasonAPIURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=current_season";
                // $currentSeasonData = file_get_contents($currentSeasonAPIURL);
                // $currentSeasonObject = json_decode($currentSeasonData, true);
                $seasonQuery = "WHERE SeasonID = 30";
            }
            // always include a recent season to narrow the scope of the request!
            $matchSummaryQuery = "{$mainQuery} {$seasonQuery} {$orderByQuery}";

            if (isset($_GET['usersearch'])) {
                // wildcard search for main search bar!
                $userEntry = $_GET['usersearch'];
                // TODO - DO I NEED TO ADD UNDERSCORES HERE OR ON THE UI?
                // $parsedUserEntry = addUnderScores($userEntry);

                // search database to check if club exists
                $checkUserQuery = "SELECT ClubID FROM epl_clubs WHERE ClubName LIKE '%{$userEntry}%' ";
                $checkUsersData = dbQueryCheckReturn($checkUserQuery);

                if (mysqli_num_rows($checkUsersData) > 1) {
                    echo "Ambiguous club, please narrow the search term";
                } elseif (mysqli_num_rows($checkUsersData) > 0) {
                    while ($row = $checkUsersData->fetch_assoc()) {
                        $usersSearchedClubID = $row['ClubID'];
                    }
                    if (!isset($_GET['season'])) {
                        $userClubQuery = "WHERE HomeClubID = {$usersSearchedClubID} OR AwayClubId = {$usersSearchedClubID}";
                        $matchSummaryQuery = "{$mainQuery} {$userClubQuery} {$orderByQuery}";
                    } else {
                        $userClubQuery = "AND (HomeClubID = {$usersSearchedClubID} OR AwayClubID = {$usersSearchedClubID})";
                        $matchSummaryQuery = "{$mainQuery} {$seasonQuery} {$userClubQuery} {$orderByQuery}";
                    }
                } else {
                    echo "no club found, please search again";
                }
            }
            if (isset($_GET['count'])) {
                $limitQuery = null;
                $matchCount = (int) $_GET['count'];
                if ($matchCount != 0 && $matchCount != null) {
                    if (isset($_GET['startat'])) {
                        $startFromNum = (int) $_GET['startat'];
                        if ($startFromNum <= $matchCount) {
                            $limitQuery = "LIMIT {$startFromNum}, {$matchCount}";
                        }
                    } else {
                        $limitQuery = "LIMIT {$matchCount}";
                    }
                }
                $matchSummaryQuery = "{$matchSummaryQuery} {$limitQuery}";
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
                    "matchid" => $row["MatchID"],
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

        if ($homeTeamNameSearch != null && $awayTeamNameSearch != null) {
            $homeClubQuery = "SELECT ClubID, ClubName FROM `epl_clubs` WHERE ClubName LIKE '%{$homeTeamNameSearch}%';";
            $awayClubQuery = "SELECT ClubID, ClubName FROM `epl_clubs` WHERE ClubName LIKE '%{$awayTeamNameSearch}%';";

            $homeClubValue = dbQueryCheckReturn($homeClubQuery);
            $awayClubValue = dbQueryCheckReturn($awayClubQuery);

            if (mysqli_num_rows($homeClubValue) != 0 && mysqli_num_rows($awayClubValue) != 0) {
                while ($homeTeamRow = $homeClubValue->fetch_assoc()) {
                    $homeTeamID = $homeTeamRow['ClubID'];
                    $homeTeamName = $homeTeamRow['ClubName'];
                }
                while ($awayTeamRow = $awayClubValue->fetch_assoc()) {
                    $awayTeamID = $awayTeamRow['ClubID'];
                    $awayTeamName = $awayTeamRow['ClubName'];
                }

                $mainQuery = "SELECT epl_matches.MatchID, epl_matches.MatchDate, epl_home_team_stats.HomeClubID, epl_away_team_stats.AwayClubID, 
                epl_home_team_stats.HTTotalGoals, epl_home_team_stats.HTHalfTimeGoals, epl_home_team_stats.HTShots, 
                epl_home_team_stats.HTShotsOnTarget, epl_home_team_stats.HTCorners, epl_home_team_stats.HTFouls, epl_home_team_stats.HTYellowCards, 
                epl_home_team_stats.HTRedCards, epl_away_team_stats.ATTotalGoals, epl_away_team_stats.ATHalfTimeGoals, 
                epl_away_team_stats.ATShots, epl_away_team_stats.ATShotsOnTarget, epl_away_team_stats.ATCorners, 
                epl_away_team_stats.ATFouls, epl_away_team_stats.ATYellowCards, epl_away_team_stats.ATRedCards
                FROM epl_matches
                INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
                INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
                INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
                INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID";

                $orderQuery = " ORDER BY MatchID ASC;";
                $defaultTeamQuery = "WHERE (epl_home_team_stats.HomeClubID = {$homeTeamID} AND epl_away_team_stats.AwayClubID = {$awayTeamID})
                OR (epl_home_team_stats.HomeClubID = {$awayTeamID} AND epl_away_team_stats.AwayClubID = {$homeTeamID})";

                if (isset($_GET['strict'])) {
                    $teamQuery = "WHERE epl_home_team_stats.HomeClubID = {$homeTeamID} AND epl_away_team_stats.AwayClubID = {$awayTeamID}";
                } else {
                    $teamQuery = $defaultTeamQuery;
                }

                $fixtureQuery = "{$mainQuery} {$teamQuery} {$orderQuery}";

                $fixtureQueryData = dbQueryCheckReturn($fixtureQuery);
                while ($row = $fixtureQueryData->fetch_assoc()) {
                    if ($row['HomeClubID'] == $homeTeamID && $row['AwayClubID'] == $awayTeamID) {
                        $teamA = $homeTeamName;
                        $teamB = $awayTeamName;
                    } else {
                        $teamA = $awayTeamName;
                        $teamB = $homeTeamName;
                    }
                    $fixture = array(
                        "hometeam" => $teamA,
                        "awayteam" => $teamB,
                        "matchdate" => $row["MatchDate"],
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
    } elseif (isset($_GET['full_matches'])) {
        // get data from matches - either a single match or a full seasons match data
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
            // singlematch - one match, all details - by match id
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
                echo "no season found";
                die();
            }
        } else {
            echo "no data";
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
    }
    echo json_encode($finalDataSet);
?>