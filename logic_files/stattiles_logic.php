<?php
    if (isset($_GET['season_pref'])) {
        $season = htmlentities(trim($_GET['season_pref']));
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$season}";
    } else {
        $currentMaxSeasonInDB = getCurrentSeason();
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$currentMaxSeasonInDB}";
    }
    $seasonAPIdata = postDevKeyInHeader($seasonInfoURL);
    $seasonGameList = json_decode($seasonAPIdata, true);

    // add all the club names into an array of current season teams
    $masterClubArray = array();

    foreach($seasonGameList as $singleMatch) {
        $homeTeamName = $singleMatch["hometeam"];
        $awayTeamName = $singleMatch["awayteam"];

        // search the full master array for club names
        // store returned result into a list of 
        $returnedNames = array_column($masterClubArray, 'clubname');

        // add the teams as a new array or the data to the existing team in the master assoc array
        if (array_search($homeTeamName, $returnedNames) != false) {
            $homeTeamKey = array_search($homeTeamName, $returnedNames);
            $masterClubArray[$homeTeamKey]['games_played'] += 1;
            $masterClubArray[$homeTeamKey]['statistics']['goals_scored'] += $singleMatch['hometeamtotalgoals'];
            $masterClubArray[$homeTeamKey]['statistics']['goals_conceded'] += $singleMatch['awayteamtotalgoals'];
            $masterClubArray[$homeTeamKey]['statistics']['shots'] += $singleMatch['hometeamshots'];
            $masterClubArray[$homeTeamKey]['statistics']['shots_on_target'] += $singleMatch['hometeamshotsontarget'];
            $masterClubArray[$homeTeamKey]['statistics']['corners'] += $singleMatch['hometeamcorners'];
            $masterClubArray[$homeTeamKey]['statistics']['fouls'] += $singleMatch['hometeamfouls'];
            $masterClubArray[$homeTeamKey]['statistics']['yellow_cards'] += $singleMatch['hometeamyellowcards'];
            $masterClubArray[$homeTeamKey]['statistics']['red_cards'] += $singleMatch['hometeamredcards'];
        } elseif (array_search($homeTeamName, $returnedNames) == false) {
            $homeTeamArray = array(
                'clubname' => $homeTeamName,
                'games_played' => 1,
                'statistics' => array(
                    'goals_scored' => $singleMatch['hometeamtotalgoals'],
                    'goals_conceded' => $singleMatch['awayteamtotalgoals'],
                    'shots' => $singleMatch['hometeamshots'],
                    'shots_on_target' => $singleMatch['hometeamshotsontarget'],
                    'corners' => $singleMatch['hometeamcorners'],
                    'fouls' => $singleMatch['hometeamfouls'],
                    'yellow_cards' => $singleMatch['hometeamyellowcards'],
                    'red_cards' => $singleMatch['hometeamredcards']
                ),
                // these stats will be updated after the full seasons data is added to each club
                'per_game_stats' => array(
                    'goals_scored_per_game' => 0.00,
                    'goals_conceded_per_game' => 0.00,
                    'shots_per_game' => 0.00,
                    'shots_on_target_per_game' => 0.00,
                    'corners_per_game' => 0.00,
                    'fouls_per_game' => 0.00,
                    'yellow_cards_per_game' => 0.00,
                    'red_cards_per_game' => 0.00
                )
            );
            $masterClubArray[] = $homeTeamArray;
        }
        
        if (array_search($awayTeamName, $returnedNames) != false) {
            $awayTeamKey = array_search($awayTeamName, $returnedNames);
            $masterClubArray[$awayTeamKey]['games_played'] += 1;
            $masterClubArray[$awayTeamKey]['statistics']['goals_scored'] += $singleMatch['awayteamtotalgoals'];
            $masterClubArray[$awayTeamKey]['statistics']['goals_conceded'] += $singleMatch['hometeamtotalgoals'];
            $masterClubArray[$awayTeamKey]['statistics']['shots'] += $singleMatch['awayteamshots'];
            $masterClubArray[$awayTeamKey]['statistics']['shots_on_target'] += $singleMatch['awayteamshotsontarget'];
            $masterClubArray[$awayTeamKey]['statistics']['corners'] += $singleMatch['awayteamcorners'];
            $masterClubArray[$awayTeamKey]['statistics']['fouls'] += $singleMatch['awayteamfouls'];
            $masterClubArray[$awayTeamKey]['statistics']['yellow_cards'] += $singleMatch['awayteamyellowcards'];
            $masterClubArray[$awayTeamKey]['statistics']['red_cards'] += $singleMatch['awayteamredcards'];
        } elseif (array_search($awayTeamName, $returnedNames) == false) {
            $awayTeamArray = array(
                'clubname' => $awayTeamName,
                'games_played' => 1,
                'statistics' => array(
                    'goals_scored' => $singleMatch['awayteamtotalgoals'],
                    'goals_conceded' => $singleMatch['hometeamtotalgoals'],
                    'shots' => $singleMatch['awayteamshots'],
                    'shots_on_target' => $singleMatch['awayteamshotsontarget'],
                    'corners' => $singleMatch['awayteamcorners'],
                    'fouls' => $singleMatch['awayteamfouls'],
                    'yellow_cards' => $singleMatch['awayteamyellowcards'],
                    'red_cards' => $singleMatch['awayteamredcards']
                ),
                // these stats will be updated after the full seasons data is added to each club
                'per_game_stats' => array(
                    'goals_scored_per_game' => 0.00,
                    'goals_conceded_per_game' => 0.00,
                    'shots_per_game' => 0.00,
                    'shots_on_target_per_game' => 0.00,
                    'corners_per_game' => 0.00,
                    'fouls_per_game' => 0.00,
                    'yellow_cards_per_game' => 0.00,
                    'red_cards_per_game' => 0.00
                )
            );
            $masterClubArray[] = $awayTeamArray;
        }
    }

    // build one array to loop through in a foreach loop for the webpage
    // every tile data array is in the order;
    // tile name, lowest value, highest value, lowest team, highest team
    $allGoalsTileData = array();
    $allConcededTileData = array();
    $allShotsTileData = array();
    $allShotsOTTileData = array();
    $allCornersTileData = array();
    $allFoulsTileData = array();
    $allYellowCardsTileData = array();
    $allRedCardsTileData = array();

    // main tile array to be looped thru
    $masterArray = array();

    $goalsScoredArray = array_column($masterClubArray, 'goals_scored');
    $allGoalsTileData[] = "Goals Scored";
    $allGoalsTileData[] = min($goalsScoredArray);
    $allGoalsTileData[] = max($goalsScoredArray);
    $minKey = array_search($allGoalsTileData[1], $masterClubArray);
    $allGoalsTileData[] = $masterClubArray[$minKey]['clubname'];
    $maxKey = array_search($allGoalsTileData[2], $masterClubArray);
    $allGoalsTileData[] = $masterClubArray[$maxKey]['clubname'];
    $masterArray[] = $allGoalsTileData;

    // $allConcededTileData[] = "Goals Conceded";
    // $allConcededTileData[] = max($allConceded);
    // $allConcededTileData[] = min($allConceded);
    // $allConcededTileData[] = findMaxValueAndReturnTeam($allConceded ,$masterClubArray);
    // $allConcededTileData[] = findMinValueAndReturnTeam($allConceded ,$masterClubArray);
    // $masterArray[] = $allConcededTileData;

    // $allShotsTileData[] = "Shots";
    // $allShotsTileData[] = min($allShots);
    // $allShotsTileData[] = max($allShots);
    // $allShotsTileData[] = findMinValueAndReturnTeam($allShots ,$masterClubArray);
    // $allShotsTileData[] = findMaxValueAndReturnTeam($allShots ,$masterClubArray);
    // $masterArray[] = $allShotsTileData;

    // $allShotsOTTileData[] = "Shots on Target";
    // $allShotsOTTileData[] = min($allShotsOT);
    // $allShotsOTTileData[] = max($allShotsOT);
    // $allShotsOTTileData[] = findMinValueAndReturnTeam($allShotsOT ,$masterClubArray);
    // $allShotsOTTileData[] = findMaxValueAndReturnTeam($allShotsOT ,$masterClubArray);
    // $masterArray[] = $allShotsOTTileData;

    // $allCornersTileData[] = "Corners";
    // $allCornersTileData[] = min($allCorners);
    // $allCornersTileData[] = max($allCorners);
    // $allCornersTileData[] = findMinValueAndReturnTeam($allCorners ,$masterClubArray);
    // $allCornersTileData[] = findMaxValueAndReturnTeam($allCorners ,$masterClubArray);
    // $masterArray[] = $allCornersTileData;

    // $allFoulsTileData[] = "Fouls";
    // $allFoulsTileData[] = max($allFouls);
    // $allFoulsTileData[] = min($allFouls);
    // $allFoulsTileData[] = findMaxValueAndReturnTeam($allFouls ,$masterClubArray);
    // $allFoulsTileData[] = findMinValueAndReturnTeam($allFouls ,$masterClubArray);
    // $masterArray[] = $allFoulsTileData;

    // $allYellowCardsTileData[] = "Yellow Cards";
    // $allYellowCardsTileData[] = max($allYellowCards);
    // $allYellowCardsTileData[] = min($allYellowCards);
    // $allYellowCardsTileData[] = findMaxValueAndReturnTeam($allYellowCards ,$masterClubArray);
    // $allYellowCardsTileData[] = findMinValueAndReturnTeam($allYellowCards ,$masterClubArray);
    // $masterArray[] = $allYellowCardsTileData;

    // $allRedCardsTileData[] = "Red Cards";
    // $allRedCardsTileData[] = max($allRedCards);
    // $allRedCardsTileData[] = min($allRedCards);
    // $allRedCardsTileData[] = findMaxValueAndReturnTeam($allRedCards ,$masterClubArray);
    // $allRedCardsTileData[] = findMinValueAndReturnTeam($allRedCards ,$masterClubArray);
    // $masterArray[] = $allRedCardsTileData;

?>