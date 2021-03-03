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
                <h1 class="title mt-4">Search Matches</h1>
                <p class="subtitle is-5 mt-2">Filter results on the panel provided</p>
            </div>
        </div>
    </section>

    <div class="columns is-mobile master_site_width">
        <!-- main 2/3 page div -->
        <div class="column is-8 mx-5">
            <!-- search bar and results filtering -->
            <section class="my-4 p-4">
                <form action="" method="get">
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            <input class="input is-rounded" type="text" placeholder="refine search"
                                name="main_page_search" id="main_page_search">
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
            </section>

            <!-- result total count bar -->
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

            <?php
                if (isset($_GET['userfilter'])) {
                    $rootURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/summary?";
                    $urlPathAddons = "";

                    if (isset($_GET['club_checkbox']) && $_GET['club_checkbox'] == "on") {
                        $clubValue = htmlentities(trim($_GET['club_select']));
                        $urlPathAddons .= "&club={$clubValue}";
                    }

                    if (isset($_GET['filter_season_checkbox']) && $_GET['filter_season_checkbox'] == "on") {
                        $seasonValue = htmlentities(trim($_GET['filter_season']));
                        $urlPathAddons .= "&season={$seasonValue}";
                    }

                    // 
                    if (isset($_GET['fixture_checkbox']) && $_GET['fixture_checkbox'] == "on") {
                        $oppositionValue = htmlentities(trim($_GET['opposition_selector']));
                        $urlPathAddons .= "&fixture={$oppositionValue}";
                    }

                    if (isset($_GET['result_checkbox']) && $_GET['result_checkbox'] == "on") {
                        $htResultValue = htmlentities(trim($_GET['ht_result']));
                        $atResultValue = htmlentities(trim($_GET['at_result']));
                        if ($htResultValue > 0 && is_numeric($htResultValue) 
                            && $atResultValue > 0 && is_numeric($atResultValue)) {
                                $urlPathAddons .= "&htresult={$htResultValue}&atresult={$atResultValue}";
                        } else {
                            echo "Unknown scores, please reenter match results";
                        }
                    }

                    if (isset($_GET['margin_checkbox']) && $_GET['margin_checkbox'] == "on") {
                        $marginValue = htmlentities(trim($_GET['user_margin']));
                        if (is_numeric($user_margin) && $user_margin > 0) {
                            $urlPathAddons .= "&margin={$marginValue}";
                        }
                    }

                    if (isset($_GET['filter_month_search']) && $_GET['filter_month_search'] == "on") {
                        $monthValue = htmlentities(trim($_GET['filter_month_selector']));
                        if ($monthValue >= 0 && $monthValue <= 11) {
                            $urlPathAddons .= "&month={$monthValue}";
                        } else {
                            echo "unknown month";
                            die();
                        }
                    }

                    if (isset($_GET['day_checkbox']) && $_GET['day_checkbox'] == "on") {
                        $dayValue = htmlentities(trim($_GET['day_selector']));
                        if ($dayValue >= 0 && $dayValue <= 6) {
                            $urlPathAddons .= "&day={$dayValue}";
                        } else {
                            echo "unknown day";
                            die();
                        }
                    }

                    if (isset($_GET['referee_selector']) && $_GET['referee_selector'] == "on") {
                        $refereeValue = htmlentities(trim($_GET['referee_selector']));
                        $urlPathAddons .= "&referee={$refereeValue}";
                    }

                    if (strlen($urlPathAddons) > 0) {
                        $finalURL = "{$rootURL}{$urlPathAddons}";
                    } else {
                        $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/summary?season=2020-2021&count=10";
                    }
                } else {
                    $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/summary?season=2020-2021&count=10";
                }
                require("part_pages/api_auth.php");
                require("part_pages/part_print_summaries.php");
            ?>
            
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

        <!-- filter panel -->
        <section id="filter_sidebar" class="mt-6 column is-one-fifth-desktop my_grey_highlight_para">
            <form action="page_advanced_search.php?userfilter" method="">
                <ul>
                    <div>
                        <p class="subtitle my-4">Filter Results:</p>
                    </div>
                    <div class="field my_grey_border p-2">
                        <div class="level field">
                            <div class="level-left">
                                <input class="checkbox level-item" type="checkbox" name="club_checkbox" id="filter_club_name_checkbox">
                                <label for="filter_club_name_checkbox" class="label level-item is-small">Club</label>
                            </div>
                            <div class="level-right">
                                <div class="select is-info is-small">
                                    <select class="my_filter_select_width control is-small level-item" name="club_select">
                                        <?php
                                            include("part_pages/part_team_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field level">
                            <div class="level-left">
                                <input checked class="level-item checkbox control" type="checkbox" name="home_checkbox"
                                    id="filter_home_checkbox" disabled="true">
                                <label for="filter_home_checkbox" class="label level-item is-small">Home</label>
                            </div>
                            <div class="level-right control">
                                <input checked class="control checkbox level-item" type="checkbox" name="away_checkbox"
                                    id="filter_away_checkbox" disabled="true">
                                <label for="filter_away_checkbox" class="label is-small level-item">Away</label>
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_season_checkbox" name="filter_season_checkbox">
                            <label class="label is-small level-item" for="filter_season_checkbox">Season</label>
                        </div>
                        <div class="level-right">
                            <div class="select is-info is-small">
                                <select name="filter_season" id="filter_season_selector" class="level-item select control is-small">
                                    <?php
                                        include("part_pages/part_season_select.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="field is-small level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_fixture_selector_checkbox" name="fixture_checkbox">
                            <label for="filter_fixture_selector_checkbox" class="label is-small level-item">Fixture</label>
                        </div>
                        <div class="select is-info is-small level-right">
                            <select name="opposition_selector" id="season_selector" class="my_filter_select_width select level-item">
                                <?php
                                    include("part_pages/part_team_selector.php");
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="field is-small level">
                        <div class="level-left">
                            <input class="checkbox is-small level-item" type="checkbox" id="filter_result_checkbox"
                                name="result_checkbox">
                            <label class="label is-small level-item" for="filter_result_checkbox">Result</label>
                        </div>
                        <div class="level-right">
                            <div class="control">
                                <input name="ht_result" type="number" id="filter_home_score" placeholder="0" min="0" max="20"
                                    class="my_filter_num_entry input is-small is-info level-item">
                            </div>
                            <p class="mx-1"> : </p>
                            <div class="control">
                                <input name="at_result" type="number" id="filter_away_score" placeholder="0" min="0" max="20"
                                    class="my_filter_num_entry input is-small is-info level-item">
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_win_margin_checkbox" name="margin_checkbox">
                            <label for="filter_win_margin_checkbox" class="label is-small level-item">Win Margin (goals)</label>
                        </div>
                        <div class="level-right">
                            <input class="input level-item my_filter_num_entry is-info is-small" type="number"
                                placeholder="0" min="1" max="20" id="filter_win_margin_user_input" name="user_margin">
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="checkbox is-small level-item" type="checkbox"
                                id="filter_month_search_checkbox" name="filter_month_search">
                            <label for="filter_month_search_checkbox" class="label is-small level-item">Month</label>
                        </div>
                        <div class="select is-info is-small level-right">
                            <div class="select">
                                <select name="filter_month_selector" id="filter_month_selector"
                                    class="my_filter_select_width level-item">
                                    <option value="0">January</option>
                                    <option value="1">February</option>
                                    <option value="2">March</option>
                                    <option value="3">April</option>
                                    <option value="4">May</option>
                                    <option value="5">June</option>
                                    <option value="6">July</option>
                                    <option selected value="7">August</option>
                                    <option value="8">September</option>
                                    <option value="9">October</option>
                                    <option value="10">November</option>
                                    <option value="11">December</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="checkbox is-small level-item" type="checkbox" id="filter_day_search_checkbox" name="day_checkbox">
                            <label for="filter_day_search_checkbox" class="label is-small level-item">Day</label>
                        </div>
                        <div class="select is-info is-small level-right">
                            <div class="select">
                                <select name="day_selector" id="filter_day_selector" class="my_filter_select_width level-item">
                                    <option value="0">Monday</option>
                                    <option value="1">Tuesday</option>
                                    <option value="2">Wednesday</option>
                                    <option value="3">Thursday</option>
                                    <option value="4">Friday</option>
                                    <option selected value="5">Saturday</option>
                                    <option value="6">Sunday</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_referee_checkbox"
                                name="filter_referee">
                            <label for="filter_referee_checkbox" class="label is-small level-item">Referee</label>
                        </div>
                        <div class="select is-info is-small my_inline_divs">
                            <select name="referee_selector" id="filter_referee_selector" class="my_filter_select_width select">
                                <?php
                                    include("part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="m-1 p-2 control">
                        <button type="reset" class="m-1 is-small button is-rounded is-info is-outlined">Reset</button>
                        <button type="submit" class="m-1 is-small button is-rounded is-info">Filter</button>
                    </div>
                </ul>
            </form>
        </section>
    </div>

    <?php include("part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>

</html>