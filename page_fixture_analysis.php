<?php
    session_start();
    require(__DIR__ . "/logic_files/fixture_analysis_logic.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(__DIR__ . "/part_pages/all_page_dependencies.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.google.com/jsapi"></script>
    <title>Fixture Analysis</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif my_min_page">
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">Fixture Analysis</h1>
                <p class="subtitle is-5 is-size-6-mobile mt-1">Select home and away teams to analyse all previous meetings</p>
            </div>
        </div>
    </section>

    <!-- main site content -->
    <div class="master_site_width">
        <section class="columns is-mobile is-vcentered m-2 mx-5 pt-4">
            <?php
                // change the layout of the search bar if nothing has been requested!
                if (!isset($_GET['ht_selector']) && !isset($_GET['at_selector'])) {
                    echo "<div class='column is-10-desktop is-offset-1-desktop my_info_colour p-3 my-6'>";
                } else {
                    echo "<div class='column is-10-desktop is-offset-1-desktop my_info_colour'>";
                }
            ?>
                <div class="column p-4 mx-3">
                    <form class="level columns form" method="GET" action="page_fixture_analysis.php">
                        <div class="column level-item">
                            <div class="select control is-expanded is-success">
                                <select required name='ht_selector' id='ht_selector' class=''>
                                    <?php
                                        require(__DIR__ . "/part_pages/part_allteams_selector.php");
                                        // control variable below for the allteams selector to make one select menu change to two clubs
                                        $htSelectorIsSet = true;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='py-2' id="switch_club_select">
                            <span class="level-item material-icons" id="switch_club_logo">swap_horiz</span>
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
                            <?php
                                // change the state of the checkbox depending on user inputs or initial page setting
                                if (isset($_GET['strict']) && (isset($_GET['ht_selector']) || $_GET['at_selector'])) {
                                    echo "<input type='checkbox' id='strict_search_box' checked name='strict'>";
                                } else {
                                    echo "<input type='checkbox' id='strict_search_box' name='strict'>";
                                }
                            ?>
                            <label for="strict_search_box">Include Reverse Fixtures</input>
                        </div>
                        <div class="column is-centered mt-0 level-item">
                            <div class="m-1">
                                <button type="submit" id="fixture_search_btn" class="button is-rounded is-danger">
                                    <span class="icon is-left">
                                        <i class="fas fa-calculator"></i>
                                    </span>
                                    <span>Analyze</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </section>
    </div>

    <?php
        if (isset($_GET['ht_selector']) && isset($_GET['at_selector'])
                && $_GET['ht_selector'] != "Select Team" 
                && $_GET['at_selector'] != "Select Team") {
            echo "
            <div class='column is-8 is-offset-2 my_sticky_div'>
                <div class='container column is-6 is-offset-3 box is-centered my_sticky_div pt-4'>
                    <div class='columns is-mobile is-vcentered is-centered m-0'>
                        <div class='column mb-2'>
                            <h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'>
                                <b>{$teamAString}</b>
                            </h4>
                        </div>
                        <div class='column level is-narrow mt-5'>
                            <h4 class='level-item'>vs.</h4>
                        </div>
                        <div class='column mb-2'>
                            <h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'>
                                <b>{$teamBString}</b>
                            </h4>
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
                        <h2 class='title is-4 is-size-5-mobile'>Key Statistics:</h2>
                    </div>";

                    for ($i = 0; $i < count($keyTileTitles); $i++) {
                        $currentIcon = $keyIcons[$i];
                        $title = $keyTileTitles[$i];
                        $calcValue = $keyTileData[$i];
                        echo "
                            <div class='columns is-vcentered is-mobile level my-4 my_fixture_stat_level'>
                                <div class='image is-24x24 ml-5'>
                                    {$currentIcon}
                                </div>
                                <div class='column is-half'>
                                    <p class='subtitle is-6 has-text-left ml-3'>{$title}</p>
                                </div>
                                <div class='column my_info_colour box my_dont_wrap_text m-2'>
                                    <p class='subtitle is-5 is-size-6-mobile m-0 my_stat_font is-one-fifth' id='fixture_total_meets_amount'><b>{$calcValue}</b>
                                    </p>
                                </div>
                            </div>";
                    };

                    echo "
                        <div class='columns level my-2 mt-6'>
                            <h2 class='title is-4 is-size-5-mobile'>Highest all Time statistics by match:</h2>
                        </div>";

                    for ($i = 0; $i < count($allTimeTileTitles); $i++) {
                        $currentWords = $allTimeTileTitles[$i];
                        $teamAStatistic = $allTimeTileHomeData[$i + $i];
                        $teamADate = $allTimeTileHomeData[($i + $i) + 1];
                        $teamBStatistic = $allTimeTileAwayData[$i + $i];
                        $teamBDate = $allTimeTileAwayData[($i + $i) + 1];
                        echo "
                            <div class='columns is-vcentered is-mobile level my-4 my_fixture_stat_level'>
                            <div class='column team_a_colour box my_dont_wrap_text m-2 p-2'>
                                <p class='subtitle is-6 m-0 my_stat_font' id='team_a_goals_amount'><b>{$teamAStatistic}</b></p>
                                <p class='m-0 mt-1 subtitle is-7 my_stat_font' id='team_a_goals_scored_date'>{$teamADate}</p>
                            </div>
                            <div class='column is-one-third'>
                                <p class='subtitle is-6'>{$currentWords}</p>
                            </div>
                            <div class='column team_b_colour box my_dont_wrap_text m-2 p-2'>
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
                                <h2 class='title is-4 is-size-5-mobile'>Metric Comparison:</h2>
                            </div>";

                        for ($i = 0; $i < count($metricTileTitles); $i++) {
                            $currentWording = $metricTileTitles[$i];
                            $teamAstat = $metricTileTitlesHomeData[$i];
                            $teamBstat = $metricTileTitlesAwayData[$i];
                            
                            echo "
                                <div class='columns is-vcentered is-mobile level my-4 my_fixture_stat_level'>
                                    <div class='column team_a_colour box my_dont_wrap_text m-2'>
                                        <p class='subtitle is-6 m-0 my_stat_font'><b>{$teamAstat}</b></p>
                                    </div>
                                    <div class='column is-one-third'>
                                        <p class='subtitle is-6'>{$currentWording}</p>
                                    </div>
                                    <div class='column team_b_colour box my_dont_wrap_text m-2'>
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
                            <h2 class='title is-3 is-size-4-mobile mt-5 p-5'>Key Statistic Charts</h2>
                        </div>
                        <section class='columns is-vcentered mx-5' >
                            <div class='mt-4 column is-6 is-4-mobile'>
                                <div class='m-2'>
                                    <div class='level my_pie_chart' id='wins_chart'></div>
                                </div>
                                <div class='m-2 mt-6'>
                                    <div class='level my_pie_chart' id='clean_sheets_chart'></div>
                                </div>
                            </div>
                            <div class='mt-4 column is-6 is-4-mobile'>
                                <div  class='m-2'>
                                    <div class='level my_pie_chart' id='goals_chart'></div>
                                </div>
                                <div class='m-2 mt-6'>
                                    <div class='level my_pie_chart' id='total_cards_chart'></div>
                                </div>
                            </div>
                        </section>
                    </div>
                    </div>";
            }
        }
        require(__DIR__ . '/part_pages/part_site_footer.php');
    ?>

    <script type="text/javascript" src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/charts/chart_pie_fixture.js"></script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalWinsArray)); ?>, 'wins_chart', 'Total Wins.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalCleanSheetsArray)); ?>, 'clean_sheets_chart', 'Total Clean Sheets.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalGoalsArray)); ?>, 'goals_chart', 'Total Goals.');</script>
    <script>drawStatPieChart(<?php print_r(json_encode($finalTotalCardsArray)); ?>, 'total_cards_chart', 'Total Cards.');</script>

    <script src="scripts/my_script.js"></script>
</body>
</html>