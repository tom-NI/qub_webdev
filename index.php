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
                    <form action="index.php" method="GET">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input is-rounded" type="text" placeholder="Search for clubs to view results"
                                    name="search" id="main_page_search">
                            </div>
                            <div class="control">
                                <button name='search_btn' class="button is-rounded is-info">
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
            <h3 class="title is-4 m-3 mt-6">Most recent Premier League results;</h3>

            <!-- most recent premier league match results -->
            <?php
                // change wording of this paragraph for admins
                if (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin"){
                    echo "<p class='subtitle is-6 m-3'>Click any result to view match details and edit or delete matches</p>";
                } else {
                    echo "<p class='subtitle is-6 m-3'>Click any result to view match details.</p>";
                }
                
                // get all the current matches from the API and print out 
                $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?count=8";
                require(__DIR__ . "/part_pages/part_print_summaries.php");
            ?>
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
                    require(__DIR__ . "/../logic_files/stattiles_logic.php");

                    foreach ($masterArray as $tileData) {
                        // tile name, lowest value, highest value, lowest team, highest team
                        $finalTitle = $tileData[0];
                        $lowStat = $tileData[1];
                        $highStat = $tileData[2];
                        $lowTeamName = $tileData[3];
                        $highTeamName = $tileData[4];

                        // calculate the games played for the club in question
                        // then calc ratio per game for display
                        $lowTeamIndex = array_search($lowTeamName, $allSeasonGamesPlayedByClub);
                        $highTeamIndex = array_search($highTeamName, $allSeasonGamesPlayedByClub);
                        $lowTeamGamesPlayed = $allSeasonGamesPlayedByClub[$lowTeamIndex];
                        $highTeamGamesPlayed = $allSeasonGamesPlayedByClub[$highTeamIndex];
                        $lowRatioPG = calculateAverageTwoDP($lowStat, $lowTeamGamesPlayed);
                        $highRatioPG = calculateAverageTwoDP($highStat ,$highTeamGamesPlayed);
                        
                        echo "
                        <div class='tile is-12 pt-5'>
                            <p><b>{$finalTitle}:</b></p>
                        </div>
                        <div class='tile is-12 is-mobile is-parent'>
                            <div class='is-child box tile'>
                                <div class=' level my-2'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$lowTeamName}</p>
                                    </div>
                                    <div class='level-right level-item my-3'>
                                        <div>
                                            <i class='material-icons redicon'>clear</i>
                                            <p class='subtitle'><b>{$lowStat}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class='subtitle is-7'>{$lowRatioPG} per match</p>
                                </div>
                            </div>
                            <div class='is-child box tile'>
                                <div class=' level my-2'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$highTeamName}</p>
                                    </div>
                                    <div class='level-right level-item my-3'>
                                        <div>
                                            <i class='material-icons greenicon'>done</i>
                                            <p class='subtitle'><b>{$highStat}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class='subtitle is-7'>{$highRatioPG} per match</p>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </section>
    </div>
    
    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>
</html>