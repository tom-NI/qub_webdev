
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fixture Analysis</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("part_site_navbar.php"); ?>

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
            <div class="column is-8-desktop is-offset-2-desktop my_info_colour">
                <div class="column p-4 mx-3">
                    <form class="level columns form" method="GET" action="page_fixture_analysis.php">
                        <div class="column level-item">
                            <div class="select control is-expanded is-success">
                                <select name='ht_selector' id='fixture_ht_selector' class=''>
                                    <?php
                                        require("part_team_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <span class="material-icons" id="swap_teams_icon">swap_horiz</span>
                        </div>
                        <div class="column level-item">
                            <div class="select control is-expanded is-danger">
                                <select name='at_selector' id='fixture_at_selector' class=''>
                                    <?php
                                        require("part_team_selector.php");
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

    <?php
        if (isset($_GET['ht_selector']) && isset($_GET['at_selector']) 
                && $_GET['ht_selector'] != "Select Team" && $_GET['at_selector'] != "Select Team") {
            require("allfunctions.php");
            $teamA = $_GET['ht_selector'];
            $teamB = $_GET['at_selector'];
            
            $finalHomeTeamurl = addUnderScores($teamA);
            $finalAwayTeamurl = addUnderScores($teamB);
            
            if (isset($_GET['strict'])) {
                $nonStrictMode = $_GET['strict'];
                if ($nonStrictMode) {
                    $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}";
                    $strictPara = "Data includes reverse fixture";
                } 
            } else {
                $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}&strict=true";
                $strictPara = "Data does NOT include reverse fixture";
            }
            $fixtureAPIdata = file_get_contents($fixtureAPIurl);
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
            }
            
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

            // data and icons for each tile (to be looped thru)
            $keyTileTitles = array(
                "Past Meetings",
                "Total Draws",
                "Average total goals per game",
                "Average total shots per game",
                "Average total fouls per game"
            );

            $keyTileData = array(
                $pastMeetingCount,
                $totalDraws,
                $averageGoalsPG,
                $averageShotsPG,
                $averageFoulsPG
            );

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

            $metricTileTitlesHomeData = array(
                $teamAWinsPercent,
                $teamAwinCount,
                $teamAcleanSheetCount,
                $teamACleanSheetsPercent,
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
                $teamBWinsPercent,
                $teamBwinCount,
                $teamBcleanSheetCount,
                $teamBCleanSheetsPercent,
                $teamBwonHalfTimeCount,
                $teamBGoalsPerGame,
                $teamBShotsPerGame,
                $teamBShotsOnTargetPerGame,
                $teamBCornersPerGame,
                $teamBFoulsPerGame,
                $teamBYellowCardsPerGame,
                $teamBRedCardsPerGame
            );

            $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$teamA}</b></h4>";
            $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-left team_b_name_colour'><b>{$teamB}</b></h4>";
        
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
                        }

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
                </div>
            </div>";
    } 
    require('part_site_footer.php');
?>
<script src='my_script.js'></script>
</body>
</html>