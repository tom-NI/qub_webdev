<?php
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(__DIR__ . "/part_pages/all_page_dependencies.php"); ?>
    <link rel="stylesheet" href="stylesheets/embla_styles.css">
    <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
    <title>EPL Match Statistic Finder</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">

    <!-- Full nav bar -->
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">The home of English Premier League Match Statistics</h1>
                <p class="subtitle is-5 is-size-6-mobile mt-2">Search below to get started</p>
            </div>
        </div>
    </section>

    <!-- home page split into two -->
    <div class="columns is-desktop master_site_width">
        <section class="column is-three-fifths-desktop mx-1">
            <div class="container is-centered">
                <!-- search bar -->
                <div class="mt-6">
                    <form action="page_advanced_search.php?count=10" method="GET">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input is-rounded" type="text" placeholder="Search for clubs to view most recent results"
                                    name="ht_selector" id="main_page_search">
                            </div>
                            <div class="control">
                                <button class="button is-rounded is-info">
                                    <span class="icon is-left">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <span>Search</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                // load the home page image carousel
                require(__DIR__ . "/part_pages/part_home_img_carousel.php");
            ?>

            <div class="level mt-6 p-2">
                <div class="level-left">
                    <div>
                        <h3 class="title is-4 is-size-5-mobile m-3 has-text-left">Recent results;</h3>
                        <p class='subtitle is-6 m-3 has-text-left'>Click any result to view match details.</p>
                    </div>
                </div>
                <?php
                    // modularized results bar
                    require(__DIR__ . "/part_pages/part_num_results_bar.php"); 
                ?>
            </div>

            <?php
                // get current matches from the API and print out
                // change if the user has changed total of matches per request
                require(__DIR__ . "/logic_files/pagination_logic.php");
                $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?{$numResultsReturnedQuery}";
                // control variable for recent matches to show > 1 page number
                $loadingRecentResults = true;
                
                // print out all match summaries
                require(__DIR__ . "/part_pages/part_print_summaries.php");
            ?>
            <div class="my-6">
                <?php require(__DIR__ . "/part_pages/part_pagination_bar_echo.php"); ?>
            </div>
        </section>

        <!-- stat tiles section -->
        <section class="section column container my_grey_highlight_para mx-5">
            <div class="container">
                <h3 class="title is-4 is-size-5-mobile mb-5">Season StatTiles</h3>
            </div>
            <div class="container my-5">
                <form method="GET" action="index.php" class="level is-mobile mb-2">
                    <div class="p-2">
                        <label for="season_select" class="mr-2"><b>Season</b></label>
                    </div>
                    <div class="select control is-expanded is-link mt-3">
                        <select name="season_pref" id="season_select">
                            <?php
                                require(__DIR__ . "/part_pages/part_season_select.php");
                            ?>
                        </select>
                    </div>
                    <div class="ml-2 level-item">
                        <button class="button is-info mt-3 mx-1">Go</button>
                    </div>
                </form>
                <p class="mb-5 is-size-6-mobile"><a href="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_chart_season.php">View all clubs statistic chart</a></p>
            </div>
            <div class="tile is-ancestor is-vertical is-10-mobile">
                <?php
                    // analyze the entire season and load the stattiles
                    require(__DIR__ . "/part_pages/part_stattiles.php");
                ?>
            </div>
            <div>
                <p class="mt-6 subtitle is-7">Stat Tiles best and worst clubs are based on the absolute statistic, not the per match statistic, which may have a higher or lower number per game in the current season based on the total matches played.</p>
            </div>
        </section>
    </div>
    
    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/embla.js"></script>
    <script src="scripts/my_script.js"></script>
</body>
</html>