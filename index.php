<?php
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/png">
    <title>EPL Match Statistic Finder</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">

    <!-- Full nav bar -->
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">The home of English Premier League Match Statistics</h1>
                <p class="subtitle is-5 mt-2">Search below to get started</p>
            </div>
        </div>
    </section>

    <!-- home page split into two -->
    <div class="columns is-desktop master_site_width">
        <section class="section column is-three-fifths-desktop mx-2">
            <div class="container is-centered">
                <!-- search bar -->
                <div>
                    <form action="page_advanced_search.php" method="GET">
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
                    <p class="mb-5 m-2"><a href="page_advanced_search.php">Advanced Match Search</a></p>
                </div>
            </div>

            <!-- image carousel! -->
            <div class="my_image_maintain_aspect">
                <figure>
                    <img src="https://i.imgur.com/Ok815ec.jpg" alt="" class="box">
                    <caption>
                        Manchester United and Liverpool are neck and neck this season in the title race
                    </caption>
                </figure>
            </div>
            
            <div class="level mt-6 p-2">
                <div class="level-left">
                    <div>
                        <h3 class="title is-4 m-3 has-text-left">Recent results;</h3>
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
                if (isset($_GET['totalresults'])) {
                    $totalReturned = htmlentities(trim($_GET['totalresults']));
                    $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?count={$totalReturned}";
                } else {
                    $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?count=10";
                }
                require(__DIR__ . "/part_pages/part_print_summaries.php");
            ?>
            <?php require(__DIR__ . "/part_pages/part_pagination.php"); ?>
        </section>

        <!-- stat tiles section -->
        <section class="section column container my_grey_highlight_para mx-5">
            <div class="container">
                <h3 class="title is-4 mb-5">StatTiles</h3>
            </div>
            <div class="container">
                <form method="GET" action="index.php" class="level mb-3">
                    <div class="p-2 level-item">
                        <label for="season_select"><b>Select Season :</b></label>
                    </div>
                    <div class="select control is-expanded is-link level-item">
                        <select name="season_pref" id="season_select">
                            <?php
                                require(__DIR__ . "/part_pages/part_season_select.php");
                            ?>
                        </select>
                    </div>
                    <div class="ml-2 level-item">
                        <button class="button is-info">Go</button>
                    </div>
                </form>
                <p class="mb-5"><a href="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_chart_season.php">View all clubs statistic chart</a></p>
            </div>
            <div class="tile is-ancestor is-vertical is-10-mobile">
                <?php
                    // analyze the entire season and load the stattiles
                    require(__DIR__ . "/logic_files/stattiles_logic.php");
                ?>
            </div>
            <div>
                <p class="mt-6 subtitle is-7">Stat Tiles best and worst clubs are based on the absolute statistic, not the per match statistic, which may have a higher or lower number per game in the current season based on the total matches played.</p>
            </div>
        </section>
    </div>
    
    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>
</html>