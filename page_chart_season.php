<?php 
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
    require(__DIR__ . "/logic_files/chart_season_logic.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.google.com/jsapi"></script>
    <title>EPL Match Result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-2 is-size-3 is-size-5-mobile">Chart Past Season Statistics</h1>
            </div>
        </div>
    </section>

        <div class='master_site_width'>
            <div class='column is-desktop is-8 is-offset-2 is-12-mobile is-vcentered my_info_colour mt-6 p-5'>
                <p class='my_info_colour title is-5 is-size-6-mobile'>Select Season and Statistic to customise the chart</p>
                <form class='level form' action="page_chart_season.php" method='GET'>
                    <div class="level-item">
                        <div class='select'>
                            <select name="season_pref" id="season_chart_select">
                                <?php
                                    require(__DIR__ . "/part_pages/part_season_select.php");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="level-item level-centre">
                        <div class='control has-icons-left mx-3'>
                            <div class='select is-info'>
                                <select class='' name='stattile_statistic'>
                                    <?php
                                        require(__DIR__ . "/part_pages/part_stattiles_stats_selector.php");
                                    ?>
                                </select>
                            </div>
                            <div class="icon is-left">
                                <i class="far fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                    <div class="level-item">
                        <button name='' class='button is-danger is-rounded'>
                            <span class="icon is-left">
                                <i class="fas fa-drafting-compass"></i>
                            </span>
                            <span class='ml-1'>Draw Chart</span>                    
                        </button>
                    </div>
                </form>
            </div>
            <?php 
                // if there is any data, draw the chart, otherwise display a warning!
                if ($noMatchesToAnalyse) {
                    echo "<div class='column is-desktop is-8 is-offset-2 is-12-mobile my-6 p-5 has-background-warning'>
                            <h3 class='is-size-5 has-text-weight-semibold'>No matches exist for this Season</h3>
                            <p class='is-size-6'>Please modify the season above and try again</p>
                        </div>";
                } else {
                    echo "
                        <div id='my_comparison_stat_list' class='mt-4 column is-10 is-offset-1'>
                            <h3 class='title is-4 is-size-5-mobile mt-6'>{$season} Season Analysis Chart</h3>
                            <p class='title is-5 is-size-6-mobile mb-0 pb-0'>Total {$statToAnalyze}</p>
                        </div>

                        <div id='my_comparison_stat_list' class='mt-4 column is-8 is-offset-1'>
                            <div class='column my_google_season_chart m-0 p-0' id='season_analysis_chart'></div>
                        </div>";

                    include_once(__DIR__ . "/charts/chart_season_analysis.php"); 
                }
            ?>
        </div>
    </div>
    <?php include(__DIR__ . '/part_pages/part_site_footer.php'); ?>
    
    <script src="scripts/my_script.js"></script>
</body>
</html>