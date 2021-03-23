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
            $overallTotalGoalsScored += $singleMatch['home_team_total_goals'];
            $overallTotalGoalsScored += $singleMatch['away_team_total_goals'];
            $overallTotalShots += $singleMatch['home_team_shots'];
            $overallTotalShots += $singleMatch['away_team_shots'];
            $overallTotalFouls += $singleMatch['home_team_fouls'];
            $overallTotalFouls += $singleMatch['away_team_fouls'];
            
            if ($singleMatch['home_team_total_goals'] == $singleMatch['away_team_total_goals']) {
                $totalDraws++;
            }
            
            if ($teamA === $singleMatch['home_team']) {
                // check the teams (for reverse fixtures) for each match and switch logic to correct team;
                if ($singleMatch['home_team_total_goals'] > $singleMatch['away_team_total_goals']) {
                    $teamAwinCount++;
                } elseif ($singleMatch['home_team_total_goals'] < $singleMatch['away_team_total_goals']) {
                    $teamBwinCount++;
                }
                // analyse all home team goals
                if ($singleMatch['home_team_total_goals'] == 0) {
                    $teamBcleanSheetCount++;
                } else {
                    $teamAgoalsScored += $singleMatch['home_team_total_goals'];
                    if ($singleMatch['home_team_total_goals'] > $teamAGoalsMax) {
                        $teamAGoalsMax = $singleMatch['home_team_total_goals'];
                        $teamAGoalsDate = $singleMatch['match_date'];
                    }
                }
                if ($singleMatch['away_team_total_goals'] == 0) {
                    $teamAcleanSheetCount++;
                } else {
                    $teamBgoalsScored += $singleMatch['away_team_total_goals'];
                    if ($singleMatch['away_team_total_goals'] > $teamBGoalsMax) {
                        $teamBGoalsMax = $singleMatch['away_team_total_goals'];
                        $teamBGoalsDate = $singleMatch['match_date'];
                    }
                }
                // analyze shots
                if ($singleMatch['home_team_shots'] > $teamAShotsMax) {
                    $teamAShotsMax = $singleMatch['home_team_shots'];
                    $teamAShotsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['away_team_shots'] > $teamBShotsMax) {
                    $teamBShotsMax = $singleMatch['away_team_shots'];
                    $teamBShotsMaxDate = $singleMatch['match_date'];
                }
                // yellow cards
                if ($singleMatch['home_team_yellow_cards'] > $teamAYellowCardsMax) {
                    $teamAYellowCardsMax = $singleMatch['home_team_yellow_cards'];
                    $teamAYellowCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['away_team_yellow_cards'] > $teamBYellowCardsMax) {
                    $teamBYellowCardsMax = $singleMatch['away_team_yellow_cards'];
                    $teamBYellowCardsMaxDate = $singleMatch['match_date'];
                }

                // red cards
                if ($singleMatch['home_team_red_cards'] > $teamARedCardsMax) {
                    $teamARedCardsMax = $singleMatch['home_team_red_cards'];
                    $teamARedCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['away_team_red_cards'] > $teamBRedCardsMax) {
                    $teamBRedCardsMax = $singleMatch['away_team_red_cards'];
                    $teamBRedCardsMaxDate = $singleMatch['match_date'];
                }

                // won by half time logic
                if (($singleMatch['home_team_half_time_goals'] > $singleMatch['away_team_half_time_goals']) 
                && ($singleMatch['home_team_total_goals'] > $singleMatch['away_team_total_goals'])) {
                    $teamAwonHalfTimeCount++;
                }
                if (($singleMatch['home_team_half_time_goals'] < $singleMatch['away_team_half_time_goals']) 
                    && ($singleMatch['home_team_total_goals'] < $singleMatch['away_team_total_goals'])) {
                        $teamBwonHalfTimeCount++;
                }
                $teamAShots += $singleMatch['home_team_shots'];
                $teamBShots += $singleMatch['away_team_shots'];
                $teamAShotsOnTarget += $singleMatch['home_team_shots_on_target'];
                $teamBShotsOnTarget += $singleMatch['away_team_shots_on_target'];
                $teamAcorners += $singleMatch['home_team_corners'];
                $teamBcorners += $singleMatch['away_team_corners'];
                $teamAfouls += $singleMatch['home_team_fouls'];
                $teamBfouls += $singleMatch['away_team_fouls'];
                $teamAyellowCards += $singleMatch['home_team_yellow_cards'];
                $teamByellowCards += $singleMatch['away_team_yellow_cards'];
                $teamARedCards += $singleMatch['home_team_red_cards'];
                $teamBRedCards += $singleMatch['away_team_red_cards'];
            } elseif ($teamA === $singleMatch['away_team']) {
                // its a reverse fixture, so count the other way round!!    
                if ($singleMatch['away_team_total_goals'] > $singleMatch['home_team_total_goals']) {
                    $teamAwinCount++;
                } elseif ($singleMatch['away_team_total_goals'] < $singleMatch['home_team_total_goals']) {
                    $teamBwinCount++;
                }
                // analyse all home team goals
                if ($singleMatch['away_team_total_goals'] == 0) {
                    $teamBcleanSheetCount++;
                } else {
                    $teamAgoalsScored += $singleMatch['away_team_total_goals'];
                    if ($singleMatch['away_team_total_goals'] > $teamAGoalsMax) {
                        $teamAGoalsMax = $singleMatch['away_team_total_goals'];
                        $teamAGoalsDate = $singleMatch['match_date'];
                    }
                }
                if ($singleMatch['home_team_total_goals'] == 0) {
                    $teamAcleanSheetCount++;
                } else {
                    $teamBgoalsScored += $singleMatch['home_team_total_goals'];
                    if ($singleMatch['home_team_total_goals'] > $teamBGoalsMax) {
                        $teamBGoalsMax = $singleMatch['home_team_total_goals'];
                        $teamBGoalsDate = $singleMatch['match_date'];
                    }
                }
                // analyze shots
                if ($singleMatch['away_team_shots'] > $teamAShotsMax) {
                    $teamAShotsMax = $singleMatch['away_team_shots'];
                    $teamAShotsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['home_team_shots'] > $teamBShotsMax) {
                    $teamBShotsMax = $singleMatch['home_team_shots'];
                    $teamBShotsMaxDate = $singleMatch['match_date'];
                }
                // yellow cards
                if ($singleMatch['away_team_yellow_cards'] > $teamAYellowCardsMax) {
                    $teamAYellowCardsMax = $singleMatch['away_team_yellow_cards'];
                    $teamAYellowCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['home_team_yellow_cards'] > $teamBYellowCardsMax) {
                    $teamBYellowCardsMax = $singleMatch['home_team_yellow_cards'];
                    $teamBYellowCardsMaxDate = $singleMatch['match_date'];
                }

                // red cards
                if ($singleMatch['away_team_red_cards'] > $teamARedCardsMax) {
                    $teamARedCardsMax = $singleMatch['away_team_red_cards'];
                    $teamARedCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch['home_team_red_cards'] > $teamBRedCardsMax) {
                    $teamBRedCardsMax = $singleMatch['home_team_red_cards'];
                    $teamBRedCardsMaxDate = $singleMatch['match_date'];
                }

                // won by half time logic
                if (($singleMatch['away_team_half_time_goals'] > $singleMatch['home_team_half_time_goals']) 
                && ($singleMatch['away_team_total_goals'] > $singleMatch['home_team_total_goals'])) {
                    $teamAwonHalfTimeCount++;
                }
                if (($singleMatch['away_team_half_time_goals'] < $singleMatch['home_team_half_time_goals']) 
                    && ($singleMatch['away_team_total_goals'] < $singleMatch['home_team_total_goals'])) {
                        $teamBwonHalfTimeCount++;
                }
                $teamAShots += $singleMatch['away_team_shots'];
                $teamBShots += $singleMatch['home_team_shots'];
                $teamAShotsOnTarget += $singleMatch['away_team_shots_on_target'];
                $teamBShotsOnTarget += $singleMatch['home_team_shots_on_target'];
                $teamAcorners += $singleMatch['away_team_corners'];
                $teamBcorners += $singleMatch['home_team_corners'];
                $teamAfouls += $singleMatch['away_team_fouls'];
                $teamBfouls += $singleMatch['home_team_fouls'];
                $teamAyellowCards += $singleMatch['away_team_yellow_cards'];
                $teamByellowCards += $singleMatch['home_team_yellow_cards'];
                $teamARedCards += $singleMatch['away_team_red_cards'];
                $teamBRedCards += $singleMatch['home_team_red_cards'];
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