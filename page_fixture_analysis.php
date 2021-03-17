<?php
    session_start(); 
    if (isset($_GET['ht_selector']) && isset($_GET['at_selector']) 
                && $_GET['ht_selector'] != "Select Team" && $_GET['at_selector'] != "Select Team") {
        include_once(__DIR__ . "/logic_files/allfunctions.php");
        $teamA = $_GET['ht_selector'];
        $teamB = $_GET['at_selector'];
        $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$teamA}</b></h4>";
        $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-left team_b_name_colour'><b>{$teamB}</b></h4>";
        
        $finalHomeTeamurl = addUnderScores($teamA);
        $finalAwayTeamurl = addUnderScores($teamB);
        
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

                // check the teams (for reverse fixtures) for each match and switch logic to correct team;
                if ($_GET['ht_selector'] == $teamA) {
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
                } 
            //     else {
            //         // I.E. theres a reverse fixture, so all the above logic is reversed...
            //         if ($singleMatch['hometeamtotalgoals'] < $singleMatch['awayteamtotalgoals']) {
            //             $teamAwinCount++;
            //         } elseif ($singleMatch['hometeamtotalgoals'] > $singleMatch['awayteamtotalgoals']) {
            //             $teamBwinCount++;
            //         }
            //         // analyse all home team goals
            //         if ($singleMatch['awayteamtotalgoals'] == 0) {
            //             $teamBcleanSheetCount++;
            //         } else {
            //             $teamAgoalsScored += $singleMatch['awayteamtotalgoals'];
            //             if ($singleMatch['awayteamtotalgoals'] > $teamAGoalsMax) {
            //                 $teamAGoalsMax = $singleMatch['awayteamtotalgoals'];
            //                 $teamAGoalsDate = $singleMatch['matchdate'];
            //             }
            //         }
            //         if ($singleMatch['hometeamtotalgoals'] == 0) {
            //             $teamAcleanSheetCount++;
            //         } else {
            //             $teamBgoalsScored += $singleMatch['hometeamtotalgoals'];
            //             if ($singleMatch['hometeamtotalgoals'] > $teamBGoalsMax) {
            //                 $teamBGoalsMax = $singleMatch['hometeamtotalgoals'];
            //                 $teamBGoalsDate = $singleMatch['matchdate'];
            //             }
            //         }
            //         // analyze shots
            //         if ($singleMatch['awayteamshots'] > $teamAShotsMax) {
            //             $teamAShotsMax = $singleMatch['awayteamshots'];
            //             $teamAShotsMaxDate = $singleMatch['matchdate'];
            //         }
            //         if ($singleMatch['hometeamshots'] > $teamBShotsMax) {
            //             $teamBShotsMax = $singleMatch['hometeamshots'];
            //             $teamBShotsMaxDate = $singleMatch['matchdate'];
            //         }
            //         // analyse fouls!
            //         if ($singleMatch['awayteamfouls'] > $teamAFoulsMax) {
            //             $teamAFoulsMax = $singleMatch['awayteamfouls'];
            //             $teamAFoulsMaxDate = $singleMatch['matchdate'];
            //         }
            //         if ($singleMatch['hometeamfouls'] > $teamBFoulsMax) {
            //             $teamBFoulsMax = $singleMatch['hometeamfouls'];
            //             $teamBFoulsMaxDate = $singleMatch['matchdate'];
            //         }
            //         // yellow cards
            //         if ($singleMatch['awayteamyellowcards'] > $teamAYellowCardsMax) {
            //             $teamAYellowCardsMax = $singleMatch['awayteamyellowcards'];
            //             $teamAYellowCardsMaxDate = $singleMatch['matchdate'];
            //         }
            //         if ($singleMatch['hometeamyellowcards'] > $teamBYellowCardsMax) {
            //             $teamBYellowCardsMax = $singleMatch['hometeamyellowcards'];
            //             $teamBYellowCardsMaxDate = $singleMatch['matchdate'];
            //         }
            //         // red cards
            //         if ($singleMatch['awayteamredcards'] > $teamARedCardsMax) {
            //             $teamARedCardsMax = $singleMatch['awayteamredcards'];
            //             $teamARedCardsMaxDate = $singleMatch['matchdate'];
            //         }
            //         if ($singleMatch['hometeamredcards'] > $teamBRedCardsMax) {
            //             $teamBRedCardsMax = $singleMatch['hometeamredcards'];
            //             $teamBRedCardsMaxDate = $singleMatch['matchdate'];
            //         }
            //         // won by half time logic
            //         if (($singleMatch['awayteamhalftimegoals'] > $singleMatch['hometeamhalftimegoals']) 
            //         && ($singleMatch['awayteamtotalgoals'] > $singleMatch['hometeamtotalgoals'])) {
            //             $teamAwonHalfTimeCount++;
            //         }
            //         if (($singleMatch['awayteamhalftimegoals'] < $singleMatch['hometeamhalftimegoals']) 
            //             && ($singleMatch['awayteamtotalgoals'] < $singleMatch['hometeamtotalgoals'])) {
            //                 $teamBwonHalfTimeCount++;
            //         }

            //         $teamAShots += $singleMatch['awayteamshots'];
            //         $teamBShots += $singleMatch['hometeamshots'];
            //         $teamAShotsOnTarget += $singleMatch['awayteamshotsontarget'];
            //         $teamBShotsOnTarget += $singleMatch['hometeamshotsontarget'];
            //         $teamAcorners += $singleMatch['awayteamcorners'];
            //         $teamBcorners += $singleMatch['hometeamcorners'];
            //         $teamAfouls += $singleMatch['awayteamfouls'];
            //         $teamBfouls += $singleMatch['hometeamfouls'];
            //         $teamAyellowCards += $singleMatch['awayteamyellowcards'];
            //         $teamByellowCards += $singleMatch['hometeamyellowcards'];
            //         $teamARedCards += $singleMatch['awayteamredcards'];
            //         $teamBRedCards += $singleMatch['hometeamredcards'];
            //     }
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
        }
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Fixture Analysis</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif my_min_page">
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Fixture Analysis</h1>
                <p class="subtitle is-5 mt-1">Select teams to analyse all previous meetings</p>
            </div>
        </div>
    </section>

    <!-- main site content -->
    <div class="master_site_width">
        
        
        <section class="columns is-mobile is-vcentered m-2 mx-5 pt-4">
            <?php
                // change the layout of the search bar if nothing has been requested!
                if (!isset($_GET['ht_selector']) && !isset($_GET['at_selector'])) {
                    echo "<div class='column is-8-desktop is-offset-2-desktop my_info_colour p-3 my-6'>";
                } else {
                    echo "<div class='column is-8-desktop is-offset-2-desktop my_info_colour'>";
                }
            ?>
                <div class="column p-4 mx-3">
                    <form class="level columns form" method="GET" action="page_fixture_analysis.php">
                        <div class="column level-item">
                            <div class="select control is-expanded is-success">
                                <select required name='ht_selector' id='ht_selector' class=''>
                                    <?php
                                        require(__DIR__ . "/part_pages/part_allteams_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="switch_club_select">
                            <span class="material-icons" id="switch_club_logo">swap_horiz</span>
                        </div>
                        <div class="column level-item">
                            <div class="select control is-expanded is-danger">
                                <select required name='at_selector' id='at_selector' class=''>
                                    <?php
                                        require(__DIR__ . "/part_pages/part_allteams_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="column is-centered mt-0 level-item">
                            <input type="checkbox" id="strict_search_box" checked name="strict">
                            <label for="strict_search_box">Include Reverse Fixtures</input>
                        </div>
                        <div class="column is-centered mt-0 level-item">
                            <div class="m-1">
                                <button type="submit" id="fixture_search_btn" class="button is-rounded is-danger">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <?php
        if (isset($_GET['ht_selector']) && isset($_GET['at_selector'])
                && $_GET['ht_selector'] != "Select Team" && $_GET['at_selector'] != "Select Team") {
            echo "
            <div class='column is-8 is-offset-2 my_sticky_div'>
                <div class='container column box is-centered my_sticky_div pt-4 mx-5'>
                    <div class='columns is-mobile is-vcentered is-centered'>
                        <div class='column mb-2'>
                            {$teamAString}
                        </div>
                        <div class='column level is-narrow mt-5'>
                            <h4 class='level-item'>vs.</h4>
                        </div>
                        <div class='column mb-2'>
                            {$teamBString}
                        </div>
                    </div>
                    <p class='subtitle is-7'>{$strictPara}</p>
                </div>
            </div>

            <!-- all tiles below -->
            <div class='master_site_width columns is-desktop '>
                <section class='column is-centered is-offset-one-fifth mx-5'>
                    <!-- main stat section of the page -->
                    <div class='columns level my-2 mt-5'>
                        <h2 class='title is-4'>Key Statistics:</h2>
                    </div>";

                    for ($i = 0; $i < count($keyTileTitles); $i++) {
                        $currentIcon = $keyIcons[$i];
                        $title = $keyTileTitles[$i];
                        $calcValue = $keyTileData[$i];
                        echo "
                            <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                                <div class='image is-24x24 ml-5'>
                                    {$currentIcon}
                                </div>
                                <div class='column is-half'>
                                    <p class='subtitle is-6 has-text-left ml-3'>{$title}</p>
                                </div>
                                <div class='column my_info_colour box my_dont_wrap_text m-3 mx-5'>
                                    <p class='subtitle is-5 m-0 my_stat_font is-one-fifth' id='fixture_total_meets_amount'><b>{$calcValue}</b>
                                    </p>
                                </div>
                            </div>";
                    };

                    echo "
                    <div class='columns level my-2 mt-6'>
                        <h2 class='title is-4 '>Highest all Time statistics by match:</h2>
                    </div>";

                    for ($i = 0; $i < count($allTimeTileTitles); $i++) {
                        $currentWords = $allTimeTileTitles[$i];
                        $teamAStatistic = $allTimeTileHomeData[$i + $i];
                        $teamADate = $allTimeTileHomeData[($i + $i) + 1];
                        $teamBStatistic = $allTimeTileAwayData[$i + $i];
                        $teamBDate = $allTimeTileAwayData[($i + $i) + 1];
                        echo "
                            <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                            <div class='column team_a_colour box my_dont_wrap_text m-3 mx-5'>
                                <p class='subtitle is-6 m-0 my_stat_font' id='team_a_goals_amount'><b>{$teamAStatistic}</b></p>
                                <p class='m-0 mt-1 subtitle is-7 my_stat_font' id='team_a_goals_scored_date'>{$teamADate}</p>
                            </div>
                            <div class='column is-one-third'>
                                <p class='subtitle is-6'>{$currentWords}</p>
                            </div>
                            <div class='column team_b_colour box my_dont_wrap_text m-3 mx-5'>
                                <p class='subtitle is-6 m-0 my_stat_font' id='team_b_goals_amount'><b>{$teamBStatistic}</b></p>
                                <p class='m-0 mt-1 subtitle is-7 my_stat_font' id='team_b_goals_scored_date'>{$teamBDate}</p>
                            </div>
                        </div>";
                    };
                    echo "
                        </section>

                        <section class='column mx-5'>
                            <!-- section header -->
                            <div class='columns level my-2 mt-5'>
                                <h2 class='title is-4'>Metric Comparison:</h2>
                            </div>";

                        for ($i = 0; $i < count($metricTileTitles); $i++) {
                            $currentWording = $metricTileTitles[$i];
                            $teamAstat = $metricTileTitlesHomeData[$i];
                            $teamBstat = $metricTileTitlesAwayData[$i];
                            
                            echo "
                                <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                                    <div class='column team_a_colour box my_dont_wrap_text m-3 mx-5'>
                                        <p class='subtitle is-6 m-0 my_stat_font'><b>{$teamAstat}</b></p>
                                    </div>
                                    <div class='column is-one-third'>
                                        <p class='subtitle is-6'>{$currentWording}</p>
                                    </div>
                                    <div class='column team_b_colour box my_dont_wrap_text m-3 mx-5'>
                                        <p class='subtitle is-6 m-0 my_stat_font'><b>{$teamBstat}</b></p>
                                    </div>
                                </div>";
                        };
            echo "
                </section>
            </div>";

            // only print out graphs if the teams have met!
            if (count($fixtureList) > 0) {
                echo "
                <!-- all graphs -->
                <div class='master_site_width'>
                    <div>
                        <h2 class='title is-3 mt-5 p-5'>Key Statistic Charts</h2>
                    </div>
                    <section class='columns is-vcentered mx-5'>
                        <div class='mt-4 column is-6 '>
                            <div class='m-2'>
                                <div class='level' id='wins_chart'></div>
                            </div>
                            <div class='m-2 mt-6'>
                                <div class='level' id='clean_sheets_chart'></div>
                            </div>
                        </div>
                        <div class='mt-4 column is-6'>
                            <div  class='m-2'>
                                <div class='level' id='goals_chart'></div>
                            </div>
                            <div class='m-2 mt-6'>
                                <div class='level' id='total_cards_chart'></div>
                            </div>
                        </div>
                    </section>
                </div>";
            }
        }
        require(__DIR__ . '/part_pages/part_site_footer.php');
    ?>

    <!-- load all my javascript graphs and pass them data from PHP -->
    <script type="text/javascript" src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/charts/chart_pie_fixture.js"></script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalWinsArray)); ?>, 'wins_chart', 'Total Wins.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalCleanSheetsArray)); ?>, 'clean_sheets_chart', 'Total Clean Sheets.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalGoalsArray)); ?>, 'goals_chart', 'Total Goals.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalTotalCardsArray)); ?>, 'total_cards_chart', 'Total Cards.');</script>

    <!-- load general javascript file -->
    <script src="scripts/my_script.js"></script>
</body>
</html>