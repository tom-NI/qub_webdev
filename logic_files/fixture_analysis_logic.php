<?php
    if (isset($_GET['ht_selector']) && isset($_GET['at_selector']) 
            && $_GET['ht_selector'] != "Select Team" && $_GET['at_selector'] != "Select Team") {
    include_once(__DIR__ . "/allfunctions.php");

    // both these unfiltered vars only use for website display
    $teamA = removeUnderScores($_GET['ht_selector']);
    $teamB = removeUnderScores($_GET['at_selector']);
    $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$teamA}</b></h4>";
    $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-left team_b_name_colour'><b>{$teamB}</b></h4>";

    $finalHomeTeamurl = addUnderScores(htmlentities(trim($teamA)));
    $finalAwayTeamurl = addUnderScores(htmlentities(trim($teamB)));

    // switch the API request based on whether user wants fixture matching or not
    if (isset($_GET['strict'])) {
        $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}";
        $strictPara = "Data includes reverse fixture";
    } else {
        $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}&strict";
        $strictPara = "Data does NOT include reverse fixture";
    }
        $fixtureAPIdata = postDevKeyInHeader($fixtureAPIurl);
        $fixtureList = json_decode($fixtureAPIdata, true);

        // initialize all analysis variables;
        $pastMeetingCount = 0;
        $totalDraws = 0;
        $overallTotalGoalsScored = 0;
        $overallTotalShots = 0;
        $overallTotalFouls = 0;

        // all the variables needed to store "Highest all Time statistics by match:" section on page
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

        // all variables needed for "Metric Comparison:" section
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

        // store icons in an array to be looped thru later
        $keyIcons = array(
            "<i class='fas fa-user-friends'></i>",
            "<i class='fas fa-equals'></i>",
            "<i class='far fa-futbol'></i>",
            "<i class='fas fa-bullseye'></i>",
            "<span class='material-icons'>sports</span>"
        );

        // store titles into arrays to be looped thru later
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
            // now loop through every match and calculate statistics
            foreach($fixtureList as $singleMatch) {
                // count major statistics regardless of clubs
                $pastMeetingCount++;
                $overallTotalGoalsScored += $singleMatch['home_team_total_goals'];
                $overallTotalGoalsScored += $singleMatch['away_team_total_goals'];
                $overallTotalShots += $singleMatch['home_team_shots'];
                $overallTotalShots += $singleMatch['away_team_shots'];
                $overallTotalFouls += $singleMatch['home_team_fouls'];
                $overallTotalFouls += $singleMatch['away_team_fouls'];
                
                // count draws logically
                if ($singleMatch['home_team_total_goals'] == $singleMatch['away_team_total_goals']) {
                    $totalDraws++;
                }

                // check teams order and set $singlematch [keys] accordingly for checking each match
                if ($teamA === $singleMatch['home_team']) {
                    $teamATotalGoalsKey = 'home_team_total_goals';
                    $teamBTotalGoalsKey = 'away_team_total_goals';
                    $teamAHtGoalsKey = 'home_team_half_time_goals';
                    $teamBHtGoalsKey = 'away_team_half_time_goals';
                    $teamAShotsKey = 'home_team_shots';
                    $teamBShotsKey = 'away_team_shots';
                    $teamAShotsOTKey = 'home_team_shots_on_target';
                    $teamBShotsOTKey = 'away_team_shots_on_target';
                    $teamACornersKey = 'home_team_corners';
                    $teamBCornersKey = 'away_team_corners';
                    $teamAFoulsKey = 'home_team_fouls';
                    $teamBFoulsKey = 'away_team_fouls';
                    $teamAYellowCardsKey = 'home_team_yellow_cards';
                    $teamBYellowCardsKey = 'away_team_yellow_cards';
                    $teamARedCardsKey = 'home_team_red_cards';
                    $teamBRedCardsKey = 'away_team_red_cards';
                } elseif ($teamA === $singleMatch['away_team']) {
                    $teamATotalGoalsKey = 'away_team_total_goals';
                    $teamBTotalGoalsKey = 'home_team_total_goals';
                    $teamAHtGoalsKey = 'away_team_half_time_goals';
                    $teamBHtGoalsKey = 'home_team_half_time_goals';
                    $teamAShotsKey = 'away_team_shots';
                    $teamBShotsKey = 'home_team_shots';
                    $teamAShotsOTKey = 'away_team_shots_on_target';
                    $teamBShotsOTKey = 'home_team_shots_on_target';
                    $teamACornersKey = 'away_team_corners';
                    $teamBCornersKey = 'home_team_corners';
                    $teamAFoulsKey = 'away_team_fouls';
                    $teamBFoulsKey = 'home_team_fouls';
                    $teamAYellowCardsKey = 'away_team_yellow_cards';
                    $teamBYellowCardsKey = 'home_team_yellow_cards';
                    $teamARedCardsKey = 'away_team_red_cards';
                    $teamBRedCardsKey = 'home_team_red_cards';
                }
                
                // check the teams (for reverse fixtures) for each match and switch logic to correct team;
                if ($singleMatch[$teamATotalGoalsKey] > $singleMatch[$teamBTotalGoalsKey]) {
                    $teamAwinCount++;
                } elseif ($singleMatch[$teamATotalGoalsKey] < $singleMatch[$teamBTotalGoalsKey]) {
                    $teamBwinCount++;
                }
                // analyse all home team goals
                if ($singleMatch[$teamATotalGoalsKey] == 0) {
                    $teamBcleanSheetCount++;
                } else {
                    $teamAgoalsScored += $singleMatch[$teamATotalGoalsKey];
                    if ($singleMatch[$teamATotalGoalsKey] > $teamAGoalsMax) {
                        $teamAGoalsMax = $singleMatch[$teamATotalGoalsKey];
                        $teamAGoalsDate = $singleMatch['match_date'];
                    }
                }
                if ($singleMatch[$teamBTotalGoalsKey] == 0) {
                    $teamAcleanSheetCount++;
                } else {
                    $teamBgoalsScored += $singleMatch[$teamBTotalGoalsKey];
                    if ($singleMatch[$teamBTotalGoalsKey] > $teamBGoalsMax) {
                        $teamBGoalsMax = $singleMatch[$teamBTotalGoalsKey];
                        $teamBGoalsDate = $singleMatch['match_date'];
                    }
                }
                // analyze shots
                if ($singleMatch[$teamAShotsKey] > $teamAShotsMax) {
                    $teamAShotsMax = $singleMatch[$teamAShotsKey];
                    $teamAShotsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch[$teamBShotsKey] > $teamBShotsMax) {
                    $teamBShotsMax = $singleMatch[$teamBShotsKey];
                    $teamBShotsMaxDate = $singleMatch['match_date'];
                }
                // yellow cards
                if ($singleMatch[$teamAYellowCardsKey] > $teamAYellowCardsMax) {
                    $teamAYellowCardsMax = $singleMatch[$teamAYellowCardsKey];
                    $teamAYellowCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch[$teamBYellowCardsKey] > $teamBYellowCardsMax) {
                    $teamBYellowCardsMax = $singleMatch[$teamBYellowCardsKey];
                    $teamBYellowCardsMaxDate = $singleMatch['match_date'];
                }

                // red cards
                if ($singleMatch[$teamARedCardsKey] > $teamARedCardsMax) {
                    $teamARedCardsMax = $singleMatch[$teamARedCardsKey];
                    $teamARedCardsMaxDate = $singleMatch['match_date'];
                }
                if ($singleMatch[$teamBRedCardsKey] > $teamBRedCardsMax) {
                    $teamBRedCardsMax = $singleMatch[$teamBRedCardsKey];
                    $teamBRedCardsMaxDate = $singleMatch['match_date'];
                }

                // calculate "won by half time" logic
                if (($singleMatch[$teamAHtGoalsKey] > $singleMatch[$teamBHtGoalsKey]) 
                && ($singleMatch[$teamATotalGoalsKey] > $singleMatch[$teamBTotalGoalsKey])) {
                    $teamAwonHalfTimeCount++;
                }
                if (($singleMatch[$teamAHtGoalsKey] < $singleMatch[$teamBHtGoalsKey]) 
                    && ($singleMatch[$teamATotalGoalsKey] < $singleMatch[$teamBTotalGoalsKey])) {
                        $teamBwonHalfTimeCount++;
                }

                // now count max fouls and set the date for both teams
                if (($singleMatch[$teamAFoulsKey] > $teamAFoulsMax)) {
                    $teamAFoulsMax = $singleMatch[$teamAFoulsKey];
                    $teamAFoulsMaxDate = $singleMatch['match_date'];
                }
                if (($singleMatch[$teamBFoulsKey] > $teamBFoulsMax)) {
                    $teamBFoulsMax = $singleMatch[$teamBFoulsKey];
                    $teamBFoulsMaxDate = $singleMatch['match_date'];
                }

                // count up simple metrics
                $teamAShots += $singleMatch[$teamAShotsKey];
                $teamBShots += $singleMatch[$teamBShotsKey];
                $teamAShotsOnTarget += $singleMatch[$teamAShotsOTKey];
                $teamBShotsOnTarget += $singleMatch[$teamBShotsOTKey];
                $teamAcorners += $singleMatch[$teamACornersKey];
                $teamBcorners += $singleMatch[$teamBCornersKey];
                $teamAfouls += $singleMatch[$teamAFoulsKey];
                $teamBfouls += $singleMatch[$teamBFoulsKey];
                $teamAyellowCards += $singleMatch[$teamAYellowCardsKey];
                $teamByellowCards += $singleMatch[$teamBYellowCardsKey];
                $teamARedCards += $singleMatch[$teamARedCardsKey];
                $teamBRedCards += $singleMatch[$teamBRedCardsKey];
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
    }
?>