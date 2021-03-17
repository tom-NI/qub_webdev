<?php
    // initialize all analysis variables;
    $pastMeetingCount = 0;
    $totalDraws = 0;
    $overallTotalGoalsScored = 0;
    $overallTotalShots = 0;
    $overallTotalFouls = 0;

    $teamAGoalsMax = 0;
    $teamBGoalsMax = 0;
    $teamAGoalsDate = null;
    $teamBGoalsDate = null;
    $teamAShotsMax = 0;
    $teamBShotsMax = 0;
    $teamAShotsMaxDate = null;
    $teamBShotsMaxDate = null;
    $teamAFoulsMax = 0;
    $teamBFoulsMax = 0;
    $teamAFoulsMaxDate = null;
    $teamBFoulsMaxDate = null;
    $teamAYellowCardsMax = 0;
    $teamBYellowCardsMax = 0;
    $teamAYellowCardsMaxDate = null;
    $teamBYellowCardsMaxDate = null;
    $teamARedCardsMax = 0;
    $teamBRedCardsMax = 0;
    $teamARedCardsMaxDate = null;
    $teamBRedCardsMaxDate = null;

    $teamAwinCount = 0;
    $teamBwinCount = 0;
    $teamAcleanSheetCount = 0;
    $teamBcleanSheetCount = 0;
    $teamAwonHalfTimeCount = 0;
    $teamBwonHalfTimeCount = 0;
    $teamAgoalsScored = 0;
    $teamBgoalsScored = 0;
    $teamAShots = 0;
    $teamBShots = 0;
    $teamAShotsOnTarget = 0;
    $teamBShotsOnTarget = 0;
    $teamAcorners = 0;
    $teamBcorners = 0;
    $teamAfouls = 0;
    $teamBfouls = 0;
    $teamAyellowCards = 0;
    $teamByellowCards = 0;
    $teamARedCards = 0;
    $teamBRedCards = 0;

    $averageGoalsPG = 0;
    $averageShotsPG = 0;
    $averageFoulsPG = 0;

    $totalWonGames = 0;
    $teamAWinsPercent = 0;
    $teamBWinsPercent = 0;
    $cleanSheetTotal = 0;
    $teamACleanSheetsPercent = 0;
    $teamBCleanSheetsPercent = 0;
    $teamAGoalsPerGame = 0;
    $teamBGoalsPerGame = 0;
    $teamAShotsPerGame = 0;
    $teamBShotsPerGame = 0;
    $teamAShotsOnTargetPerGame = 0;
    $teamBShotsOnTargetPerGame = 0;
    $teamACornersPerGame = 0;
    $teamBCornersPerGame = 0;
    $teamAFoulsPerGame = 0;
    $teamBFoulsPerGame = 0;
    $teamAYellowCardsPerGame = 0;
    $teamBYellowCardsPerGame = 0;
    $teamARedCardsPerGame = 0;
    $teamBRedCardsPerGame = 0;

    $keyIcons = array(
        "<i class='fas fa-user-friends'></i>",
        "<i class='fas fa-equals'></i>",
        "<i class='far fa-futbol'></i>",
        "<i class='fas fa-bullseye'></i>",
        "<span class='material-icons'>sports</span>"
    );

    $allTimeTileTitles = array(
        "Goals Scored",
        "Shots on Goal",
        "Fouls",
        "Yellow Cards",
        "Red Cards"
    );

    $keyTileTitles = array(
        "Past Meetings",
        "Total Draws",
        "Average total goals per game",
        "Average total shots per game",
        "Average total fouls per game"
    );

    $metricTileTitles = array(
        "Percentage wins",
        "Win count",
        "Clean Sheets",
        "% Clean Sheets",
        "Games Won by Half Time",
        "Goals per game",
        "Shots per game",
        "Shots on target",
        "Average corners per game",
        "Fouls per game",
        "Yellow Cards per game",
        "Red Cards per game"
    );

    // only calculate the stats if there is data to display
    if (count($fixtureList) > 0) {
        foreach($fixtureList as $singleMatch) {
            $pastMeetingCount++;
            $overallTotalGoalsScored += $singleMatch['hometeamtotalgoals'];
            $overallTotalGoalsScored += $singleMatch['awayteamtotalgoals'];
            $overallTotalShots += $singleMatch['hometeamshots'];
            $overallTotalShots += $singleMatch['awayteamshots'];
            $overallTotalFouls += $singleMatch['hometeamfouls'];
            $overallTotalFouls += $singleMatch['awayteamfouls'];
            
            if ($singleMatch['hometeamtotalgoals'] == $singleMatch['awayteamtotalgoals']) {
                $totalDraws++;
            }
            
            if ($teamA === $singleMatch['hometeam']) {
                // check the teams (for reverse fixtures) for each match and switch logic to correct team;
                if ($singleMatch['hometeamtotalgoals'] > $singleMatch['awayteamtotalgoals']) {
                    $teamAwinCount++;
                } elseif ($singleMatch['hometeamtotalgoals'] < $singleMatch['awayteamtotalgoals']) {
                    $teamBwinCount++;
                }
                // analyse all home team goals
                if ($singleMatch['hometeamtotalgoals'] == 0) {
                    $teamBcleanSheetCount++;
                } else {
                    $teamAgoalsScored += $singleMatch['hometeamtotalgoals'];
                    if ($singleMatch['hometeamtotalgoals'] > $teamAGoalsMax) {
                        $teamAGoalsMax = $singleMatch['hometeamtotalgoals'];
                        $teamAGoalsDate = $singleMatch['matchdate'];
                    }
                }
                if ($singleMatch['awayteamtotalgoals'] == 0) {
                    $teamAcleanSheetCount++;
                } else {
                    $teamBgoalsScored += $singleMatch['awayteamtotalgoals'];
                    if ($singleMatch['awayteamtotalgoals'] > $teamBGoalsMax) {
                        $teamBGoalsMax = $singleMatch['awayteamtotalgoals'];
                        $teamBGoalsDate = $singleMatch['matchdate'];
                    }
                }
                // analyze shots
                if ($singleMatch['hometeamshots'] > $teamAShotsMax) {
                    $teamAShotsMax = $singleMatch['hometeamshots'];
                    $teamAShotsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamshots'] > $teamBShotsMax) {
                    $teamBShotsMax = $singleMatch['awayteamshots'];
                    $teamBShotsMaxDate = $singleMatch['matchdate'];
                }
                // yellow cards
                if ($singleMatch['hometeamyellowcards'] > $teamAYellowCardsMax) {
                    $teamAYellowCardsMax = $singleMatch['hometeamyellowcards'];
                    $teamAYellowCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamyellowcards'] > $teamBYellowCardsMax) {
                    $teamBYellowCardsMax = $singleMatch['awayteamyellowcards'];
                    $teamBYellowCardsMaxDate = $singleMatch['matchdate'];
                }

                // red cards
                if ($singleMatch['hometeamredcards'] > $teamARedCardsMax) {
                    $teamARedCardsMax = $singleMatch['hometeamredcards'];
                    $teamARedCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamredcards'] > $teamBRedCardsMax) {
                    $teamBRedCardsMax = $singleMatch['awayteamredcards'];
                    $teamBRedCardsMaxDate = $singleMatch['matchdate'];
                }

                // won by half time logic
                if (($singleMatch['hometeamhalftimegoals'] > $singleMatch['awayteamhalftimegoals']) 
                && ($singleMatch['hometeamtotalgoals'] > $singleMatch['awayteamtotalgoals'])) {
                    $teamAwonHalfTimeCount++;
                }
                if (($singleMatch['hometeamhalftimegoals'] < $singleMatch['awayteamhalftimegoals']) 
                    && ($singleMatch['hometeamtotalgoals'] < $singleMatch['awayteamtotalgoals'])) {
                        $teamBwonHalfTimeCount++;
                }
                $teamAShots += $singleMatch['hometeamshots'];
                $teamBShots += $singleMatch['awayteamshots'];
                $teamAShotsOnTarget += $singleMatch['hometeamshotsontarget'];
                $teamBShotsOnTarget += $singleMatch['awayteamshotsontarget'];
                $teamAcorners += $singleMatch['hometeamcorners'];
                $teamBcorners += $singleMatch['awayteamcorners'];
                $teamAfouls += $singleMatch['hometeamfouls'];
                $teamBfouls += $singleMatch['awayteamfouls'];
                $teamAyellowCards += $singleMatch['hometeamyellowcards'];
                $teamByellowCards += $singleMatch['awayteamyellowcards'];
                $teamARedCards += $singleMatch['hometeamredcards'];
                $teamBRedCards += $singleMatch['awayteamredcards'];
            } elseif ($teamA === $singleMatch['awayteam']) {
                // its a reverse fixture, so count the other way round!!    
                if ($singleMatch['awayteamtotalgoals'] > $singleMatch['hometeamtotalgoals']) {
                    $teamAwinCount++;
                } elseif ($singleMatch['awayteamtotalgoals'] < $singleMatch['hometeamtotalgoals']) {
                    $teamBwinCount++;
                }
                // analyse all home team goals
                if ($singleMatch['awayteamtotalgoals'] == 0) {
                    $teamBcleanSheetCount++;
                } else {
                    $teamAgoalsScored += $singleMatch['awayteamtotalgoals'];
                    if ($singleMatch['awayteamtotalgoals'] > $teamAGoalsMax) {
                        $teamAGoalsMax = $singleMatch['awayteamtotalgoals'];
                        $teamAGoalsDate = $singleMatch['matchdate'];
                    }
                }
                if ($singleMatch['hometeamtotalgoals'] == 0) {
                    $teamAcleanSheetCount++;
                } else {
                    $teamBgoalsScored += $singleMatch['hometeamtotalgoals'];
                    if ($singleMatch['hometeamtotalgoals'] > $teamBGoalsMax) {
                        $teamBGoalsMax = $singleMatch['hometeamtotalgoals'];
                        $teamBGoalsDate = $singleMatch['matchdate'];
                    }
                }
                // analyze shots
                if ($singleMatch['awayteamshots'] > $teamAShotsMax) {
                    $teamAShotsMax = $singleMatch['awayteamshots'];
                    $teamAShotsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['hometeamshots'] > $teamBShotsMax) {
                    $teamBShotsMax = $singleMatch['hometeamshots'];
                    $teamBShotsMaxDate = $singleMatch['matchdate'];
                }
                // yellow cards
                if ($singleMatch['awayteamyellowcards'] > $teamAYellowCardsMax) {
                    $teamAYellowCardsMax = $singleMatch['awayteamyellowcards'];
                    $teamAYellowCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['hometeamyellowcards'] > $teamBYellowCardsMax) {
                    $teamBYellowCardsMax = $singleMatch['hometeamyellowcards'];
                    $teamBYellowCardsMaxDate = $singleMatch['matchdate'];
                }

                // red cards
                if ($singleMatch['awayteamredcards'] > $teamARedCardsMax) {
                    $teamARedCardsMax = $singleMatch['awayteamredcards'];
                    $teamARedCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['hometeamredcards'] > $teamBRedCardsMax) {
                    $teamBRedCardsMax = $singleMatch['hometeamredcards'];
                    $teamBRedCardsMaxDate = $singleMatch['matchdate'];
                }

                // won by half time logic
                if (($singleMatch['awayteamhalftimegoals'] > $singleMatch['hometeamhalftimegoals']) 
                && ($singleMatch['awayteamtotalgoals'] > $singleMatch['hometeamtotalgoals'])) {
                    $teamAwonHalfTimeCount++;
                }
                if (($singleMatch['awayteamhalftimegoals'] < $singleMatch['hometeamhalftimegoals']) 
                    && ($singleMatch['awayteamtotalgoals'] < $singleMatch['hometeamtotalgoals'])) {
                        $teamBwonHalfTimeCount++;
                }
                $teamAShots += $singleMatch['awayteamshots'];
                $teamBShots += $singleMatch['hometeamshots'];
                $teamAShotsOnTarget += $singleMatch['awayteamshotsontarget'];
                $teamBShotsOnTarget += $singleMatch['hometeamshotsontarget'];
                $teamAcorners += $singleMatch['awayteamcorners'];
                $teamBcorners += $singleMatch['hometeamcorners'];
                $teamAfouls += $singleMatch['awayteamfouls'];
                $teamBfouls += $singleMatch['hometeamfouls'];
                $teamAyellowCards += $singleMatch['awayteamyellowcards'];
                $teamByellowCards += $singleMatch['hometeamyellowcards'];
                $teamARedCards += $singleMatch['awayteamredcards'];
                $teamBRedCards += $singleMatch['hometeamredcards'];
            }
        }
    };
        
    // calc averages
    if ($pastMeetingCount > 0) {
        $averageGoalsPG = calculateAverage($overallTotalGoalsScored, $pastMeetingCount);
        $averageShotsPG = calculateAverage($overallTotalShots, $pastMeetingCount);
        $averageFoulsPG = calculateAverage($overallTotalFouls, $pastMeetingCount);
    }

    // percent and metric calcs
    $totalWonGames = $pastMeetingCount - $totalDraws;
    $teamAWinsPercent = calculatePercentage($teamAwinCount, $totalWonGames);
    $teamBWinsPercent = calculatePercentage($teamBwinCount, $totalWonGames);
    $cleanSheetTotal = ($teamAcleanSheetCount + $teamBcleanSheetCount);
    $teamACleanSheetsPercent = calculatePercentage($teamAcleanSheetCount, $cleanSheetTotal);
    $teamBCleanSheetsPercent = calculatePercentage($teamBcleanSheetCount, $cleanSheetTotal);
    $teamAGoalsPerGame = calculateAverage($teamAgoalsScored, $pastMeetingCount);
    $teamBGoalsPerGame = calculateAverage($teamBgoalsScored, $pastMeetingCount);
    $teamAShotsPerGame = calculateAverage($teamAShots ,$pastMeetingCount);
    $teamBShotsPerGame = calculateAverage($teamBShots ,$pastMeetingCount);
    $teamAShotsOnTargetPerGame = calculateAverage($teamAShotsOnTarget ,$pastMeetingCount);
    $teamBShotsOnTargetPerGame = calculateAverage($teamBShotsOnTarget ,$pastMeetingCount);
    $teamACornersPerGame = calculateAverage($teamAcorners ,$pastMeetingCount);
    $teamBCornersPerGame = calculateAverage($teamBcorners ,$pastMeetingCount);
    $teamAFoulsPerGame = calculateAverage($teamAfouls ,$pastMeetingCount);
    $teamBFoulsPerGame = calculateAverage($teamBfouls ,$pastMeetingCount);
    $teamAYellowCardsPerGame = calculateAverage($teamAyellowCards ,$pastMeetingCount);
    $teamBYellowCardsPerGame = calculateAverage($teamByellowCards ,$pastMeetingCount);
    $teamARedCardsPerGame = calculateAverage($teamARedCards ,$pastMeetingCount);
    $teamBRedCardsPerGame = calculateAverage($teamBRedCards ,$pastMeetingCount);
    
    // data for each tile (to be looped thru)
    $keyTileData = array(
        $pastMeetingCount,
        $totalDraws,
        $averageGoalsPG,
        $averageShotsPG,
        $averageFoulsPG
    );

    $allTimeTileHomeData = array(
        $teamAGoalsMax,
        $teamAGoalsDate,
        $teamAShotsMax,
        $teamAShotsMaxDate,
        $teamAFoulsMax,
        $teamAFoulsMaxDate,
        $teamAYellowCardsMax,
        $teamAYellowCardsMaxDate,
        $teamARedCardsMax,
        $teamARedCardsMaxDate
    );

    $allTimeTileAwayData = array(
        $teamBGoalsMax,
        $teamBGoalsDate,
        $teamBShotsMax,
        $teamBShotsMaxDate,
        $teamBFoulsMax,
        $teamBFoulsMaxDate,
        $teamBYellowCardsMax,
        $teamBYellowCardsMaxDate,
        $teamBRedCardsMax,
        $teamBRedCardsMaxDate
    );

    $metricTileTitlesHomeData = array(
        "{$teamAWinsPercent}%",
        $teamAwinCount,
        $teamAcleanSheetCount,
        "{$teamACleanSheetsPercent}%",
        $teamAwonHalfTimeCount,
        $teamAGoalsPerGame,
        $teamAShotsPerGame,
        $teamAShotsOnTargetPerGame,
        $teamACornersPerGame,
        $teamAFoulsPerGame,
        $teamAYellowCardsPerGame,
        $teamBRedCardsPerGame
    );

    $metricTileTitlesAwayData = array(
        "{$teamBWinsPercent}%",
        $teamBwinCount,
        $teamBcleanSheetCount,
        "{$teamBCleanSheetsPercent}%",
        $teamBwonHalfTimeCount,
        $teamBGoalsPerGame,
        $teamBShotsPerGame,
        $teamBShotsOnTargetPerGame,
        $teamBCornersPerGame,
        $teamBFoulsPerGame,
        $teamBYellowCardsPerGame,
        $teamBRedCardsPerGame
    );

    if (count($fixtureList) > 0) {
        // setup team names array for all pie charts!
        $pieChartLabelsArray = array();
        array_push($pieChartLabelsArray, "Club", "Total");
        
        // build all array objects for graphs
        $finalWinsArray = array();
        $homeClubWins = array();
        array_push($homeClubWins, $teamA, $metricTileTitlesHomeData[1]);
        $awayClubWins = array();
        array_push($awayClubWins, $teamB, $metricTileTitlesAwayData[1]);
        array_push($finalWinsArray, $pieChartLabelsArray, $homeClubWins, $awayClubWins);
        
        // build clean sheets chart array!
        $finalCleanSheetsArray = array();
        $cleanSheetsTeamA = array();
        array_push($cleanSheetsTeamA, $teamA, $metricTileTitlesHomeData[2]);
        $cleanSheetsTeamB = array();
        array_push($cleanSheetsTeamB, $teamB, $metricTileTitlesAwayData[2]);
        array_push($finalCleanSheetsArray, $pieChartLabelsArray, $cleanSheetsTeamA, $cleanSheetsTeamB);
        
        // build goals chart array
        $finalGoalsArray = array();
        $teamAGoals = array();
        array_push($teamAGoals, $teamA, $teamAgoalsScored);
        $teamBGoals = array();
        array_push($teamBGoals, $teamB, $teamBgoalsScored);
        array_push($finalGoalsArray, $pieChartLabelsArray, $teamAGoals, $teamBGoals);
        
        // build total cards chart array
        $finalTotalCardsArray = array();
        $teamACards = array();
        array_push($teamACards, $teamA, ($teamAyellowCards + $teamARedCards));
        $teamBCards = array();
        array_push($teamBCards, $teamB, ($teamByellowCards + $teamBRedCards));
        array_push($finalTotalCardsArray, $pieChartLabelsArray, $teamACards, $teamBCards);
    }

?>