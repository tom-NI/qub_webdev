
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
            $homeTeam = $_GET['ht_selector'];
            $awayTeam = $_GET['at_selector'];

            // TODO - check reverse fixture logic!!
            
            $finalHomeTeamurl = addUnderScores($homeTeam);
            $finalAwayTeamurl = addUnderScores($awayTeam);
            
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

            $HTGoalsMax = 0;
            $ATGoalsMax = 0;
            $HTGoalsMaxDate = null;
            $ATGoalsMaxDate = null;
            $HTShotsMax = 0;
            $ATShotsMax = 0;
            $HTShotsMaxDate = null;
            $ATShotsMaxDate = null;
            $HTFoulsMax = 0;
            $ATFoulsMax = 0;
            $HTFoulsMaxDate = null;
            $ATFoulsMaxDate = null;
            $HTYellowCardsMax = 0;
            $ATYellowCardsMax = 0;
            $HTYellowCardsMaxDate = null;
            $ATYellowCardsMaxDate = null;
            $HTRedCardsMax = 0;
            $ATRedCardsMax = 0;
            $HTRedCardsMaxDate = null;
            $ATRedCardsMaxDate = null;

            $HTwinCount = 0;
            $ATwinCount = 0;
            $HTcleanSheetCount = 0;
            $ATcleanSheetCount = 0;
            $HTwonHalfTimeCount = 0;
            $ATwonHalfTimeCount = 0;
            $HTgoalsScored = 0;
            $ATgoalsScored = 0;
            $HTShots = 0;
            $ATShots = 0;
            $HTShotsOnTarget = 0;
            $ATShotsOnTarget = 0;
            $HTcorners = 0;
            $ATcorners = 0;
            $HTfouls = 0;
            $ATfouls = 0;
            $HTyellowCards = 0;
            $ATyellowCards = 0;
            $HTRedCards = 0;
            $ATRedCards = 0;

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
                } elseif ($singleMatch['hometeamtotalgoals'] > $singleMatch['awayteamtotalgoals']) {
                    $HTwinCount++;
                } else {
                    $ATwinCount++;
                }

                // analyse all home team goals
                if ($singleMatch['hometeamtotalgoals'] == 0) {
                    $ATcleanSheetCount++;
                } else {
                    $HTgoalsScored += $singleMatch['hometeamtotalgoals'];
                    if ($singleMatch['hometeamtotalgoals'] > $HTGoalsMax) {
                        $HTGoalsMax = $singleMatch['hometeamtotalgoals'];
                        $HTGoalsMaxDate = $singleMatch['matchdate'];
                    }
                }
                if ($singleMatch['awayteamtotalgoals'] == 0) {
                    $HTcleanSheetCount++;
                } else {
                    $ATgoalsScored += $singleMatch['awayteamtotalgoals'];
                    if ($singleMatch['awayteamtotalgoals'] > $ATGoalsMax) {
                        $ATGoalsMax = $singleMatch['awayteamtotalgoals'];
                        $ATGoalsMaxDate = $singleMatch['matchdate'];
                    }
                }

                // analyze shots
                if ($singleMatch['hometeamshots'] > $HTShotsMax) {
                    $HTShotsMax = $singleMatch['hometeamshots'];
                    $HTShotsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamshots'] > $ATShotsMax) {
                    $ATShotsMax = $singleMatch['awayteamshots'];
                    $ATShotsMaxDate = $singleMatch['matchdate'];
                }

                // analyse fouls!
                if ($singleMatch['hometeamfouls'] > $HTFoulsMax) {
                    $HTFoulsMax = $singleMatch['hometeamfouls'];
                    $HTFoulsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamfouls'] > $ATFoulsMax) {
                    $ATFoulsMax = $singleMatch['awayteamfouls'];
                    $ATFoulsMaxDate = $singleMatch['matchdate'];
                }

                // yellow cards
                if ($singleMatch['hometeamyellowcards'] > $HTYellowCardsMax) {
                    $HTYellowCardsMax = $singleMatch['hometeamyellowcards'];
                    $HTYellowCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamyellowcards'] > $ATYellowCardsMax) {
                    $ATYellowCardsMax = $singleMatch['awayteamyellowcards'];
                    $ATYellowCardsMaxDate = $singleMatch['matchdate'];
                }

                // red cards
                if ($singleMatch['hometeamredcards'] > $HTRedCardsMax) {
                    $HTRedCardsMax = $singleMatch['hometeamredcards'];
                    $HTRedCardsMaxDate = $singleMatch['matchdate'];
                }
                if ($singleMatch['awayteamredcards'] > $ATRedCardsMax) {
                    $ATRedCardsMax = $singleMatch['awayteamredcards'];
                    $ATRedCardsMaxDate = $singleMatch['matchdate'];
                }

                $HTShots += $singleMatch['hometeamshots'];
                $ATShots += $singleMatch['awayteamshots'];
                $HTShotsOnTarget += $singleMatch['hometeamshotsontarget'];
                $ATShotsOnTarget += $singleMatch['awayteamshotsontarget'];
                $HTcorners += $singleMatch['hometeamcorners'];
                $ATcorners += $singleMatch['awayteamcorners'];
                $HTfouls += $singleMatch['hometeamfouls'];
                $ATfouls += $singleMatch['awayteamfouls'];
                $HTyellowCards += $singleMatch['hometeamyellowcards'];
                $ATyellowCards += $singleMatch['awayteamyellowcards'];
                $HTRedCards += $singleMatch['hometeamredcards'];
                $ATRedCards += $singleMatch['awayteamredcards'];
                
                // won by half time logic
                if (($singleMatch['hometeamhalftimegoals'] > $singleMatch['awayteamhalftimegoals']) 
                    && ($singleMatch['hometeamtotalgoals'] > $singleMatch['awayteamtotalgoals'])) {
                        $HTwonHalfTimeCount++;
                }
                if (($singleMatch['hometeamhalftimegoals'] < $singleMatch['awayteamhalftimegoals']) 
                    && ($singleMatch['hometeamtotalgoals'] < $singleMatch['awayteamtotalgoals'])) {
                        $ATwonHalfTimeCount++;
                }
            }
            
            // calc averages
            if ($pastMeetingCount > 0) {
                $averageGoalsPG = calculateAverage($overallTotalGoalsScored, $pastMeetingCount);
                $averageShotsPG = calculateAverage($overallTotalShots, $pastMeetingCount);
                $averageFoulsPG = calculateAverage($overallTotalFouls, $pastMeetingCount);
            }

            // percent and metric calcs
            $totalWonGames = $pastMeetingCount - $totalDraws;
            $htWinsPercent = calculatePercentage($HTwinCount, $totalWonGames);
            $atWinsPercent = calculatePercentage($ATwinCount, $totalWonGames);
            $cleanSheetTotal = ($HTcleanSheetCount + $ATcleanSheetCount);
            $htCleanSheetsPercent = calculatePercentage($HTcleanSheetCount, $cleanSheetTotal);
            $atCleanSheetsPercent = calculatePercentage($ATcleanSheetCount, $cleanSheetTotal);
            $htGoalsPerGame = calculateAverage($HTgoalsScored, $pastMeetingCount);
            $atGoalsPerGame = calculateAverage($ATgoalsScored, $pastMeetingCount);
            $htShotsPerGame = calculateAverage($HTShots ,$pastMeetingCount);
            $atShotsPerGame = calculateAverage($ATShots ,$pastMeetingCount);
            $htShotsOnTargetPerGame = calculateAverage($HTShotsOnTarget ,$pastMeetingCount);
            $atShotsOnTargetPerGame = calculateAverage($ATShotsOnTarget ,$pastMeetingCount);
            $htCornersPerGame = calculateAverage($HTcorners ,$pastMeetingCount);
            $atCornersPerGame = calculateAverage($ATcorners ,$pastMeetingCount);
            $htFoulsPerGame = calculateAverage($HTfouls ,$pastMeetingCount);
            $atFoulsPerGame = calculateAverage($ATfouls ,$pastMeetingCount);
            $htYellowCardsPerGame = calculateAverage($HTyellowCards ,$pastMeetingCount);
            $atYellowCardsPerGame = calculateAverage($ATyellowCards ,$pastMeetingCount);
            $htRedCardsPerGame = calculateAverage($HTRedCards ,$pastMeetingCount);
            $atRedCardsPerGame = calculateAverage($ATRedCards ,$pastMeetingCount);

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
                $HTGoalsMax,
                $HTGoalsMaxDate,
                $HTShotsMax,
                $HTShotsMaxDate,
                $HTFoulsMax,
                $HTFoulsMaxDate,
                $HTYellowCardsMax,
                $HTYellowCardsMaxDate,
                $HTRedCardsMax,
                $HTRedCardsMaxDate
            );

            $allTimeTileAwayData = array(
                $ATGoalsMax,
                $ATGoalsMaxDate,
                $ATShotsMax,
                $ATShotsMaxDate,
                $ATFoulsMax,
                $ATFoulsMaxDate,
                $ATYellowCardsMax,
                $ATYellowCardsMaxDate,
                $ATRedCardsMax,
                $ATRedCardsMaxDate
            );

            $metricTileTitles = array(
                "Percentage wins",
                "Win count",
                "% clean sheets",
                "Games Won by Half Time",
                "Goals per game",
                "Shots per game",
                "Shots on target",
                "Clean Sheets",
                "Average corners per game",
                "Fouls per game",
                "Yellow Cards per game",
                "Red Cards per game"
            );

            $metricTileTitlesHomeData = array(
                $htWinsPercent,
                $HTwinCount,
                $htCleanSheetsPercent,
                $HTwonHalfTimeCount,
                $htGoalsPerGame,
                $htShotsPerGame,
                $htShotsOnTargetPerGame,
                $HTcleanSheetCount,
                $htCornersPerGame,
                $htFoulsPerGame,
                $htYellowCardsPerGame,
                $atRedCardsPerGame
            );

            $metricTileTitlesAwayData = array(
                $atWinsPercent,
                $ATwinCount,
                $atCleanSheetsPercent,
                $ATwonHalfTimeCount,
                $atGoalsPerGame,
                $atShotsPerGame,
                $atShotsOnTargetPerGame,
                $ATcleanSheetCount,
                $atCornersPerGame,
                $atFoulsPerGame,
                $atYellowCardsPerGame,
                $atRedCardsPerGame
            );

            $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$homeTeam}</b></h4>";
            $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-left team_b_name_colour'><b>{$awayTeam}</b></h4>";
        
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
                        }
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
                            }
                        echo"
                    </section>
                </div>
            </div>";
    } 
    require('part_site_footer.php');
?>
<script src='my_script.js'></script>
</body>
</html>