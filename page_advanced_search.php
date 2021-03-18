<?php 
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");

    if (isset($_GET['userfilter'])) {
        // if the user checked the filter panel items - do this;
        $rootURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?filter";
        $urlPathAddons = "";

        // club select (labelled as home team)
        if (isset($_GET['ht_selector']) && $_GET['ht_selector'] != "" 
                && $_GET['ht_selector'] != "Select Team") {
            $clubValue = addUnderScores(htmlentities(trim($_GET['ht_selector'])));
            $urlPathAddons .= "&club={$clubValue}";
        }

        // opposition team (away team)
        if (isset($_GET['at_selector']) && $_GET['at_selector'] != ""
                && $_GET['at_selector'] != "Select Team") {
            $oppositionValue = addUnderScores(htmlentities(trim($_GET['at_selector'])));
            $urlPathAddons .= "&opposition_team={$oppositionValue}";
        }

        if (isset($_GET['season_pref']) && $_GET['season_pref'] != "" 
                && $_GET['season_pref'] != "none") {
            $seasonValue = htmlentities(trim($_GET['season_pref']));
            $urlPathAddons .= "&season={$seasonValue}";
        }

        if (isset($_GET['ht_result']) && $_GET['ht_result'] != "") {
            $htResultValue = (int) htmlentities(trim($_GET['ht_result']));
            if (is_numeric($htResultValue) && $htResultValue >= 0) {
                $urlPathAddons .= "&htresult={$htResultValue}";
            }
        }
        if (isset($_GET['at_result']) && $_GET['at_result'] != "") {
            $atResultValue = (int) htmlentities(trim($_GET['at_result']));
            if (is_numeric($atResultValue) && $atResultValue >= 0) {
                $urlPathAddons .= "&atresult={$atResultValue}";
            }
        }

        if (isset($_GET['user_margin']) && $_GET['user_margin'] != "") {
            $marginValue = (int) htmlentities(trim($_GET['user_margin']));
            if (is_numeric($marginValue) && $marginValue > 0) {
                $urlPathAddons .= "&margin={$marginValue}";
            }
        }

        if (isset($_GET['filter_month_selector']) && $_GET['filter_month_selector'] != "" 
                && $_GET['filter_month_selector'] != "none") {
            $monthValue = htmlentities(trim($_GET['filter_month_selector']));
            if ($monthValue >= 01 && $monthValue <= 12) {
                $urlPathAddons .= "&month={$monthValue}";
            }
        }

        if (isset($_GET['day_selector']) && $_GET['day_selector'] != "" 
                && $_GET['day_selector'] != "none") {
            $dayValue = htmlentities(trim($_GET['day_selector']));
            if ($dayValue >= 1 && $dayValue <= 7) {
                $urlPathAddons .= "&day={$dayValue}";
            }
        }

        if (isset($_GET['referee_selector']) && $_GET['referee_selector'] != "" 
                && $_GET['referee_selector'] != "Select Referee") {
            $refereeValue = addUnderScores(htmlentities(trim($_GET['referee_selector'])));
            $urlPathAddons .= "&referee={$refereeValue}";
        }

        // todo add in pagination parameters

        // if (isset($_GET['25_results'])) {
        //     $numResultsReturnedQuery = "&count=25";
        // } elseif (isset($_GET['50_results'])) {
        //     $numResultsReturnedQuery = "&count=50";
        // } else {
        //     $numResultsReturnedQuery = "&count=10";
        // }

        // if (isset($_GET['pagenumber'])) {
        //     $pageNumber = (int) htmlentities(trim($_GET['pagenumber']));
        // } else {
        //     $pageNumber = 1;
        // }

        // if ($pageNumber > 1) {
        //     $pageQuery = "&startat={$pageNumber}";
        // } else {
        //     $pageQuery = "&startat=1";
        // }

        // {$numResultsReturnedQuery}{$pageQuery}

        if (strlen($urlPathAddons) > 0) {
            $finalURL = "{$rootURL}{$urlPathAddons}";
        } else {
            $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?season=2020-2021{$numResultsReturnedQuery}{$pageQuery}";
        }
    } elseif (isset($_GET['match_search'])) {
        // if the user entered something in the club search bar
        $userSearchItem = htmlentities(trim($_GET['match_search']));
        $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?usersearch={$userSearchItem}";
    } else {
        // otherwise just load the last ten premier league 
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
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- main  banner -->
    <section class="hero is-info is-bold pt-4">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-2">Search Matches</h1>
                <p class="subtitle is-5 mt-2">Filter results on the panel provided</p>
            </div>
        </div>
    </section>

    <!-- search bar -->
    <div class="master_site_width">
    <div class="column is-8 is-offset-2 my-5 p-5">
        <?php 
            if (isset($queryResult1)) {
            echo "<div class='my-3 p-5 has-background-warning'>
                    <div>
                        <h3 class='title is-5'>{$queryResult1}</h3>
                    </div>
                </div>";
            }
        ?>
        </div>
    </div>

    <div class="master_site_width">
        <div class="columns">
        <div class="column is-8 is-offset-2">
            <!-- filter panel -->
            <div class="p-3 pb-5 my_info_colour">
                <div class="column level mt-2 is-12 is-centered mb-3">
                    <div class='level'>
                        <span class="level-item level-left ">
                            <span class="title is-4 my_info_colour ml-4">Find Matches :</span>
                        </span>
                        <span id='collapse_info' class="level-item level-right mr-4">
                            <i class="fas fa-info"></i>
                        </span>
                    </div>
                </div>
                <div id='search_info_box' class="column is-12 is-centered my_collapsing_div">
                    <ul>
                        <li class="subtitle is-5 my_info_colour has-text-left ml-4">
                        Search Information:
                        </li>
                        <li class="subtitle is-6 my_info_colour has-text-left ml-4">
                        1) Searching for two clubs without home and way goals will show all matches for both clubs.</li>
                        <li class="subtitle is-6 my_info_colour has-text-left ml-4">
                        2) Searching for two clubs with home and away goals will strictly match the fixture.</li>
                        <li class="subtitle is-6 mb-5 my_info_colour has-text-left ml-4">
                        3) Searching for two clubs with either home or away goals will return any result of those two clubs where the home/away result matches.</li>
                    </ul>
                </div>

                <form class="columns is-centered" action="page_advanced_search.php?userfilter" method="GET">
                    <div class="column is-6">
                        <div class="level">
                            <span class="level-item level-left ml-4">Club :</span>
                            <div class="level-right">
                                <div class="select is-info">
                                    <select name="ht_selector" class="control level-item my_filter_select_width">
                                        <?php
                                            include(__DIR__ . "/part_pages/part_allteams_selector.php");
                                            // control variable below for the allteams selector to make one select menu change to two clubs
                                            $htSelectorIsSet = true;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="level">
                            <span for="filter_fixture_selector_checkbox" class="level-item level-left ml-4">Opposition :</span>
                            <div class="select is-info level-right">
                                <select name="at_selector" id="season_selector" class="level-item my_filter_select_width">
                                    <?php
                                        include(__DIR__ . "/part_pages/part_allteams_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="level">
                            <span for="filter_season_selector" class="level-item level-left ml-4">Season :</span>
                            <div class="select is-info level-right">
                                <select name="season_pref" id="filter_season_selector" class="level-item select control my_filter_select_width">
                                    <option value='none'>None</option>
                                    <?php
                                        // control var to change the state of the season default selected item
                                        $findMatchPage = true;
                                        include(__DIR__ . "/part_pages/part_season_select.php");
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="level">
                            <span for="filter_home_score" class="level-item level-left ml-4">Home Goals :</span>
                            <div>
                                <div class="level-right">
                                    <div class="control">
                                    <?php
                                        // save the users entered value in the form that they previously set
                                        if (isset($htResultValue) && is_numeric($htResultValue) && $htResultValue >= 0) {
                                            echo "<input name='ht_result' type='number' id='filter_home_score' maxlength='2' placeholder='0' min='0' max='20' value={$htResultValue} class='input is-info my_filter_num_entry level-item'>";
                                        } else {
                                            echo "<input name='ht_result' type='number' id='filter_home_score' maxlength='2' placeholder='0' min='0' max='20' class='input is-info my_filter_num_entry level-item'>";
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="level">
                            <span class="level-item level-left ml-4">Away Goals :</span>
                            <div class="level-right">
                                <div class="control">
                                <?php
                                    // save the users entered value in the form that they previously set
                                    if (isset($atResultValue) && is_numeric($atResultValue) && $atResultValue >= 0) {
                                        echo "<input name='at_result' type='number' id='filter_home_score' maxlength='2' placeholder='0' min='0' max='20' value={$atResultValue} class='input is-info my_filter_num_entry level-item'>";
                                    } else {
                                        echo "<input name='at_result' type='number' id='filter_home_score' maxlength='2' placeholder='0' min='0' max='20' class='input is-info my_filter_num_entry level-item'>";
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <span class="level-item level-left ml-4">Win Margin (Goals) :</span>
                            <div>
                                <div class="level-right">
                                <?php
                                    // save the users entered value in the form that they previously set
                                    if (isset($marginValue) && is_numeric($marginValue) && $marginValue > 0) {
                                        echo "<input class='input level-item my_filter_num_entry is-info' type='number'
                                        placeholder='0' value={$marginValue} min='1' max='20' maxlength='2' id='filter_win_margin_user_input' name='user_margin'>";
                                    } else {
                                        echo "<input class='input level-item my_filter_num_entry is-info' type='number'
                                        placeholder='0' min='1' max='20' maxlength='2' id='filter_win_margin_user_input' name='user_margin'>";
                                    }
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <span class="level-item level-left ml-4">Month :</span>
                            <div class="select is-info level-right">
                                <div class="select">
                                    <select name="filter_month_selector" id="filter_month_selector" class="my_filter_select_width level-item">
                                        <?php
                                            include(__DIR__ . "/part_pages/part_month_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="level">
                            <span class="level-item level-left ml-4">Referee :</span>
                            <div class="select is-info my_inline_divs">
                                <select name="referee_selector" id="filter_referee_selector" class="my_filter_select_width select">
                                    <?php
                                        include(__DIR__ . "/part_pages/part_referee_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-12 level">
                    <div class="level-item level-right">
                        <button type="reset" class="m-2 mx-2 button is-rounded is-info is-outlined">Reset</button>
                        <button type="submit" name='userfilter' class="m-2 mx-2 button is-rounded is-info">Find Match Results</button>
                    </div>
                </div>
            </div>
            </form>
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
                            <button name='25_results' class="button is-outlined is-small is-info ">
                                <p>25</p>
                            </button>
                        </p>
                        <p class="control">
                            <button name='50_results' class="button is-outlined is-small is-info">
                                <p>50</p>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- print out all match summaries as requested based on the final URL variable-->
        <?php require(__DIR__ . "/part_pages/part_print_summaries.php"); ?>

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

    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>

</html>