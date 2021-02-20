<?php
    require("allfunctions.php");
    if (isset($_GET['season_pref'])) {
        $season = $_GET['season_pref'];
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/?full_matches&fullseason={$season}";
    } else {
        $currentMaxSeasonInDB = getCurrentSeason();
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/?full_matches&fullseason={$currentMaxSeasonInDB}";
    }
    $seasonAPIdata = file_get_contents($seasonInfoURL);
    $seasonGameList = json_decode($seasonAPIdata, true);

    // add all the club names into an array of current season teams
    $allSeasonClubNames = array();

    // store every metric to be measured in an array
    $consistency = array();
    $allGoals = array();
    $allConceded = array();
    $allShots = array();
    $allShotsOT = array();
    $allCorners = array();
    $allFouls = array();
    $allYellowCards = array();
    $allRedCards = array();

    foreach($seasonGameList as $singleMatch) {
        $homeTeamName = $singleMatch["hometeam"];
        $awayTeamName = $singleMatch["awayteam"];

        // check if the team is in the season clubs, if not add.
        // always return the index to use later
        if (array_search($homeTeamName, $allSeasonClubNames)) {
            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
            echo $homeTeamIndex;
        } else {
            $allSeasonClubNames[] = $homeTeamName;
            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
        }
        if (array_search($awayTeamName, $allSeasonClubNames)) {
            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
            echo $awayTeamIndex;
        } else {
            $allSeasonClubNames[] = $awayTeamName;
            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
        }

        $allgoals[$homeTeamIndex] += $singleMatch["hometeamtotalgoals"];
        $allConceded[$awayTeamIndex] += $singleMatch["hometeamtotalgoals"];
        $allShots[$homeTeamIndex] += $singleMatch["hometeamshots"];
        $allShotsOT[$homeTeamIndex] += $singleMatch["hometeamshotsontarget"];
        $allCorners[$homeTeamIndex] += $singleMatch["hometeamcorners"];
        $allFouls[$homeTeamIndex] += $singleMatch["hometeamfouls"];
        $allYellowCards[$homeTeamIndex] += $singleMatch["hometeamyellowcards"];
        $allRedCards[$homeTeamIndex] += $singleMatch["hometeamredcards"];

        $allgoals[$awayTeamIndex] += $singleMatch["awayteamtotalgoals"];
        $allConceded[$homeTeamIndex] += $singleMatch["awayteamtotalgoals"];
        $allShots[$awayTeamIndex] += $singleMatch["awayteamshots"];
        $allShotsOT[$awayTeamIndex] += $singleMatch["awayteamshotsontarget"];
        $allCorners[$awayTeamIndex] += $singleMatch["awayteamcorners"];
        $allFouls[$awayTeamIndex] += $singleMatch["awayteamfouls"];
        $allYellowCards[$awayTeamIndex] += $singleMatch["awayteamyellowcards"];
        $allRedCards[$awayTeamIndex] += $singleMatch["awayteamredcards"];
    }
    
    // TODO - DO I DO CONSISTENCY METRIC OR NOT?
    // $lowestConsistencyValue;
    // $highestConsistencyValue;
    // $lowestConsistencyTeam;
    // $highestConsistencyTeam;

    $lowestGoalsValue = max($allGoals);
    $highestGoalsValue = min($allGoals);
    $lowestGoalsTeam = findMaxValueAndReturnTeam($allGoals ,$allSeasonClubNames);
    $highestGoalsTeam = findMinValueAndReturnTeam($allGoals ,$allSeasonClubNames);

    $lowestConcededValue = min($allConceded);
    $highestConcededValue = max($allConceded);
    $lowestConcededTeam = findMinValueAndReturnTeam($allConceded ,$allSeasonClubNames);
    $highestConcededTeam = findMaxValueAndReturnTeam($allConceded ,$allSeasonClubNames);

    $lowestShotsValue = min($allShots);
    $highestShotsValue = max($allShots);
    $lowestShotsTeam = findMinValueAndReturnTeam($allShots ,$allSeasonClubNames);
    $highestShotsTeam = findMaxValueAndReturnTeam($allShots ,$allSeasonClubNames);

    $lowestShotsOTValue = min($allShotsOT);
    $highestShotsOTValue = max($allShotsOT);
    $lowestShotsOTTeam = findMinValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);
    $highestShotsOTTeam = findMaxValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);

    $lowestCornersValue = min($allCorners);
    $highestCornersValue = max($allCorners);
    $lowestCornersTeam = findMinValueAndReturnTeam($allCorners ,$allSeasonClubNames);
    $highestCornersTeam = findMaxValueAndReturnTeam($allCorners ,$allSeasonClubNames);

    $lowestFoulsValue = min($allFouls);
    $highestFoulsValue = max($allFouls);
    $lowestFoulsTeam = findMinValueAndReturnTeam($allFouls ,$allSeasonClubNames);
    $highestFoulsTeam = findMaxValueAndReturnTeam($allFouls ,$allSeasonClubNames);

    $lowestYellowCardsValue = min($allYellowCards);
    $highestYellowCardsValue = max($allYellowCards);
    $lowestYellowCardsTeam = findMinValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
    $highestYellowCardsTeam = findMaxValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);

    $lowestRedCardsValue = min($allRedCards);
    $highestRedCardsValue = max($allRedCards);
    $lowestRedCardsTeam = findMinValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
    $highestRedCardsTeam = findMaxValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
?>