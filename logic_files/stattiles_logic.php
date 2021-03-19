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
    $allSeasonClubNames = array();

    // array that stores the total number of games each team has played
    // (whose index will then match the allSeasonClubNames) 
    $allSeasonGamesPlayedByClub = array();

    // store every metric to be measured in an array
    $allGoals = array();
    $allConceded = array();
    $allShots = array();
    $allShotsOT = array();
    $allCorners = array();
    $allFouls = array();
    $allYellowCards = array();
    $allRedCards = array();

    foreach($seasonGameList as $singleMatch) {
        $homeTeamName = trim($singleMatch["hometeam"]);
        $awayTeamName = trim($singleMatch["awayteam"]);

        // check if the team is in the allSeasonClubNames array, if not add.
        // return club index to use later in the code
        if (array_search($homeTeamName, $allSeasonClubNames) !== false) {
            $homeTeamIndex = (int) array_search($homeTeamName, $allSeasonClubNames);
            $allSeasonGamesPlayedByClub[$homeTeamIndex] += 1;
        } else {
            // otherwise add the item to the array, and then return its index
            array_push($allSeasonClubNames, $homeTeamName);
            array_push($allSeasonGamesPlayedByClub, 1);
            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
        }
        if (array_search($awayTeamName, $allSeasonClubNames) !== false) {
            $awayTeamIndex = (int) array_search($awayTeamName, $allSeasonClubNames);
            $allSeasonGamesPlayedByClub[$awayTeamIndex] += 1;
        } else {
            array_push($allSeasonClubNames, $awayTeamName);
            array_push($allSeasonGamesPlayedByClub, 1);
            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
        }
        
        // check if the teams index exists in the array and add on data if so
        // else, push the data onto the end of the array, array is updated for each func call
        $allGoals = searchAndAddToArray($singleMatch["hometeamtotalgoals"], $allGoals, $homeTeamIndex);
        $allConceded = searchAndAddToArray($singleMatch["hometeamtotalgoals"], $allConceded, $awayTeamIndex);
        $allShots = searchAndAddToArray($singleMatch["hometeamshots"], $allShots, $homeTeamIndex);
        $allShotsOT = searchAndAddToArray($singleMatch["hometeamshotsontarget"], $allShotsOT, $homeTeamIndex);
        $allCorners = searchAndAddToArray($singleMatch["hometeamcorners"], $allCorners, $homeTeamIndex);
        $allFouls = searchAndAddToArray($singleMatch["hometeamfouls"], $allFouls, $homeTeamIndex);
        $allYellowCards = searchAndAddToArray($singleMatch["hometeamyellowcards"], $allYellowCards, $homeTeamIndex);
        $allRedCards = searchAndAddToArray($singleMatch["hometeamredcards"], $allRedCards, $homeTeamIndex);
        
        $allGoals = searchAndAddToArray($singleMatch["awayteamtotalgoals"], $allGoals, $awayTeamIndex);
        $allConceded = searchAndAddToArray($singleMatch["awayteamtotalgoals"], $allConceded, $homeTeamIndex);
        $allShots = searchAndAddToArray($singleMatch["awayteamshots"], $allShots, $awayTeamIndex);
        $allShotsOT = searchAndAddToArray($singleMatch["awayteamshotsontarget"], $allShotsOT, $awayTeamIndex);
        $allCorners = searchAndAddToArray($singleMatch["awayteamcorners"], $allCorners, $awayTeamIndex);
        $allFouls = searchAndAddToArray($singleMatch["awayteamfouls"], $allFouls, $awayTeamIndex);
        $allYellowCards = searchAndAddToArray($singleMatch["awayteamyellowcards"], $allYellowCards, $awayTeamIndex);
        $allRedCards = searchAndAddToArray($singleMatch["awayteamredcards"], $allRedCards, $awayTeamIndex);
    }

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

    $allGoalsTileData[] = "Goals Scored";
    $allGoalsTileData[] = min($allGoals);
    $allGoalsTileData[] = max($allGoals);
    $allGoalsTileData[] = findMinValueAndReturnTeam($allGoals ,$allSeasonClubNames);
    $allGoalsTileData[] = findMaxValueAndReturnTeam($allGoals ,$allSeasonClubNames);
    $masterArray[] = $allGoalsTileData;

    $allConcededTileData[] = "Goals Conceded";
    $allConcededTileData[] = max($allConceded);
    $allConcededTileData[] = min($allConceded);
    $allConcededTileData[] = findMaxValueAndReturnTeam($allConceded ,$allSeasonClubNames);
    $allConcededTileData[] = findMinValueAndReturnTeam($allConceded ,$allSeasonClubNames);
    $masterArray[] = $allConcededTileData;

    $allShotsTileData[] = "Shots";
    $allShotsTileData[] = min($allShots);
    $allShotsTileData[] = max($allShots);
    $allShotsTileData[] = findMinValueAndReturnTeam($allShots ,$allSeasonClubNames);
    $allShotsTileData[] = findMaxValueAndReturnTeam($allShots ,$allSeasonClubNames);
    $masterArray[] = $allShotsTileData;

    $allShotsOTTileData[] = "Shots on Target";
    $allShotsOTTileData[] = min($allShotsOT);
    $allShotsOTTileData[] = max($allShotsOT);
    $allShotsOTTileData[] = findMinValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);
    $allShotsOTTileData[] = findMaxValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);
    $masterArray[] = $allShotsOTTileData;

    $allCornersTileData[] = "Corners";
    $allCornersTileData[] = min($allCorners);
    $allCornersTileData[] = max($allCorners);
    $allCornersTileData[] = findMinValueAndReturnTeam($allCorners ,$allSeasonClubNames);
    $allCornersTileData[] = findMaxValueAndReturnTeam($allCorners ,$allSeasonClubNames);
    $masterArray[] = $allCornersTileData;

    $allFoulsTileData[] = "Fouls";
    $allFoulsTileData[] = max($allFouls);
    $allFoulsTileData[] = min($allFouls);
    $allFoulsTileData[] = findMaxValueAndReturnTeam($allFouls ,$allSeasonClubNames);
    $allFoulsTileData[] = findMinValueAndReturnTeam($allFouls ,$allSeasonClubNames);
    $masterArray[] = $allFoulsTileData;

    $allYellowCardsTileData[] = "Yellow Cards";
    $allYellowCardsTileData[] = max($allYellowCards);
    $allYellowCardsTileData[] = min($allYellowCards);
    $allYellowCardsTileData[] = findMaxValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
    $allYellowCardsTileData[] = findMinValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
    $masterArray[] = $allYellowCardsTileData;

    $allRedCardsTileData[] = "Red Cards";
    $allRedCardsTileData[] = max($allRedCards);
    $allRedCardsTileData[] = min($allRedCards);
    $allRedCardsTileData[] = findMaxValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
    $allRedCardsTileData[] = findMinValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
    $masterArray[] = $allRedCardsTileData;

?>