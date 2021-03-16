<?php 
    session_start();

    if (isset($_GET['userfilter'])) {
        $rootURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?filter";
        $urlPathAddons = "";

        if (isset($_GET['club_select']) && $_GET['club_select'] != "Select Team") {
            $clubValue = addUnderScores(htmlentities(trim($_GET['club_select'])));
            $urlPathAddons .= "&club={$clubValue}";
        }

        if (isset($_GET['filter_season']) && $_GET['filter_season'] != "none") {
            $seasonValue = htmlentities(trim($_GET['filter_season']));
            $urlPathAddons .= "&season={$seasonValue}";
        }

        if (isset($_GET['at_selector']) && $_GET['at_selector'] != "Select Team") {
            $oppositionValue = htmlentities(trim($_GET['at_selector']));
            $urlPathAddons .= "&opposition_team={$oppositionValue}";
        }

        if (isset($_GET['ht_result'])) {
            $htResultValue = (int) htmlentities(trim($_GET['ht_result']));
            if (is_numeric($htResultValue) && $htResultValue >= 0) {
                $urlPathAddons .= "&htresult={$htResultValue}";
            }
        }
        if (isset($_GET['at_result'])) {
            $atResultValue = (int) htmlentities(trim($_GET['at_result']));
            if (is_numeric($atResultValue) && $atResultValue >= 0) {
                $urlPathAddons .= "&atresult={$atResultValue}";
            }
        }

        if (isset($_GET['user_margin']) && is_numeric($_GET['user_margin']) && $_GET['user_margin'] > 0) {
            $marginValue = htmlentities(trim($_GET['user_margin']));
            $urlPathAddons .= "&margin={$marginValue}";
        }

        if (isset($_GET['filter_month_selector']) && $_GET['filter_month_selector'] != "none") {
            $monthValue = htmlentities(trim($_GET['filter_month_selector']));
            if ($monthValue >= 01 && $monthValue <= 12) {
                $urlPathAddons .= "&month={$monthValue}";
            }
        }

        if (isset($_GET['day_selector']) && $_GET['day_selector'] != "none") {
            $dayValue = htmlentities(trim($_GET['day_selector']));
            if ($dayValue >= 1 && $dayValue <= 7) {
                $urlPathAddons .= "&day={$dayValue}";
            }
        }

        if (isset($_GET['referee_selector']) && $_GET['referee_selector'] != "Select Referee") {
            $refereeValue = htmlentities(trim($_GET['referee_selector']));
            $urlPathAddons .= "&referee={$refereeValue}";
        }

        // todo add in default pagination parameters

        if (strlen($urlPathAddons) > 0) {
            $finalURL = "{$rootURL}{$urlPathAddons}";
        } else {
            $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?season=2020-2021&count=10";
        }
    } elseif (isset($_GET['match_search'])) {
        $userSearchItem = htmlentities(trim($_GET['match_search']));
        $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?usersearch={$userSearchItem}";
    } else {
        $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?season=2020-2021&count=10";
    }
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
    <title>Advanced Search</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif	">
    <!-- Full nav bar -->
    <?php include("part_pages/part_site_navbar.php"); ?>

    <!-- main  banner -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-3">Search Matches</h1>
                <p class="subtitle is-5 mt-2">Filter results on the panel provided</p>
            </div>
        </div>
    </section>

    <div class="master_site_width">
        <!-- main 2/3 page div -->
        <div class="columns is-mobile">
        <div class="column is-8 is-offset-2">
            <!-- filter panel -->
            <div class="mx-4 p-3 my_grey_highlight_para mt-4">
                <div class="column is-12">
                    <h3 class="title is-4 mb-5 my_grey_highlight_para" >Find Matches:</h3>
                </div>
                <form class="columns" action="page_advanced_search.php?userfilter" method="GET">
                    <div class="column is-6">
                        <div class="level">
                            <p class="level-item level-left ml-4">Club :</p>
                            <div class="level-right">
                                <div class="select is-info">
                                    <select class="control level-item my_filter_select_width" name="club_select">
                                        <?php
                                            include("part_pages/part_allteams_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="level">
                            <p for="filter_fixture_selector_checkbox" class="level-item level-left ml-4">Opposition :</p>
                            <div class="select is-info level-right">
                                <select name="at_selector" id="season_selector" class="level-item my_filter_select_width">
                                    <?php
                                        include("part_pages/part_allteams_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="level">
                            <p for="filter_season_selector" class="level-item level-left ml-4">Season :</p>
                            <div class="select is-info level-right">
                                <select name="filter_season" id="filter_season_selector" class="level-item select control my_filter_select_width">
                                    <option value='none'>None</option>
                                    <?php
                                        include("part_pages/part_season_select.php");
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="level">
                            <p for="filter_home_score" class="level-item level-left ml-4">Home Goals :</p>
                            <div>
                                <div class="level-right">
                                    <div class="control">
                                        <input name="ht_result" type="number" id="filter_home_score" maxlength='2' placeholder="0" min="0" max="20"
                                            class="input is-info my_filter_num_entry level-item">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="level">
                            <p class="level-item level-left ml-4">Away Goals :</p>
                            <div class="level-right">
                                <div class="control">
                                <input name="at_result" type="number" id="filter_away_score" maxlength='2' placeholder="0" min="0" max="20"
                                    class="my_filter_num_entry input is-info level-item">
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <p class="level-item level-left ml-4">Win Margin (Goals) :</p>
                            <div>
                                <div class="level-right">
                                    <input class="input level-item my_filter_num_entry is-info" type="number"
                                        placeholder="0" min="1" max="20" maxlength='2' id="filter_win_margin_user_input" name="user_margin">
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <p class="level-item level-left ml-4">Month :</p>
                            <div class="select is-info level-right">
                                <div class="select">
                                    <select name="filter_month_selector" id="filter_month_selector" class="my_filter_select_width level-item">
                                        <option selected value="none">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <p class="level-item level-left ml-4">Referee :</p>
                            <div class="select is-info my_inline_divs">
                                <select name="referee_selector" id="filter_referee_selector" class="my_filter_select_width select">
                                    <?php
                                        include("part_pages/part_referee_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-1 p-2 control column is-12 level">
                    <div class="level-item level-right">
                        <button type="reset" class="m-2 mx-2 button is-rounded is-info is-outlined">Reset</button>
                        <button type="submit" name='userfilter' class="m-2 mx-2 button is-rounded is-info">Find Match Results</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </form>

        <!-- search bar and results filtering -->
    <div class="master_site_width">
        <div class="column is-8 is-offset-2 my-3">
            <form action="page_advanced_search.php?" method="get">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <?php
                            if (isset($_GET['match_search'])) {
                                $usersSearch = htmlentities(trim($_GET['match_search']));
                                echo "<input class='input is-rounded' type='text' value='{$usersSearch}' placeholder='Search for Clubs most recent results here' name='match_search' id='main_page_search'>";
                            } else {
                                echo "<input class='input is-rounded' type='text' placeholder='Search for Clubs most recent results here' name='match_search' id='main_page_search'>";
                            }
                        ?>
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
            <?php 
                if (isset($queryResult1)) {
                echo "<div class='my-3 p-5 has-background-warning'>
                        <div>
                            <h3 class='title is-5'>{$queryResult1}</h3>
                        </div>
                    </div>";
                }
                if (isset($queryResult2)) {
                echo "<div class='my-3 p-5 has-background-warning'>
                        <div>
                            <h3 class='title is-5'>{$queryResult2}</h3>
                        </div>
                    </div>";
                }
                if (isset($queryResult3)) {
                echo "<div class='my-3 p-5 has-background-warning'>
                        <div>
                            <h3 class='title is-5'>{$queryResult3}</h3>
                        </div>
                    </div>";
                }
            ?>
        </div>
    </div>

    <div class="columns is-mobile master_site_width">
        <!-- result total count bar -->
        <section class="column is-8 is-offset-2">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-4 has-text-left m-3">Search results;</h1>
                    <p class="subtitle is-6 m-3 has-text-left">Click any result to view match details</p>
                </div>
            </div>
            <div class="my_inline_divs p-4 level-left">
                <div class="level-item">
                    <p class="pr-3">Number of results:</p>
                    <div class="field has-addons">
                        <p class="control">
                            <button class="button is-small is-info">
                                <p>10</p>
                            </button>
                        </p>
                        <p class="control">
                            <button class="button is-outlined is-small is-info ">
                                <p>25</p>
                            </button>
                        </p>
                        <p class="control">
                            <button class="button is-outlined is-small is-info">
                                <p>50</p>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- print out all match summaries as requested -->
        <?php require("part_pages/part_print_summaries.php"); ?>
        </section>

        <nav class="pagination mt-6 mx-3 mb-4">
            <span class="mr-3">
                <p>Go to Page :</p>
            </span>
            <a href="" class="pagination-previous is-outlined button is-info " id="pagination_prev_button"
                disabled>Previous</a>
            <a href="" class="pagination-next is-outlined button is-info " id="pagination_next_button">Next</a>
            <ul class="pagination-list is-centered">
                <li><a href="" id="pagination_page_button_1" class="pagination-link is-info button">1</a></li>
                <li><a href="" id="pagination_page_button_2" class="pagination-link is-info is-outlined button">2</a></li>
                <li><a href="" id="pagination_page_button_3" class="pagination-link is-info is-outlined button">3</a></li>
            </ul>
        </nav>
    </div>

    <?php include("part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>

</html>