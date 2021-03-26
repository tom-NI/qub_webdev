<?php 
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
    require(__DIR__ . "/logic_files/pagination_logic.php");
    require(__DIR__ . "/logic_files/advanced_search_logic.php");
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

    <div class="master_site_width">
        <!-- filter panel -->
        <div>
        <div class="p-3 mt-5 my_info_colour column is-8 is-offset-2">
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

        <form action="page_advanced_search.php?userfilter" method="GET">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="level ml-4">
                        <span class="level-item level-left">Club :</span>
                        <div class="level-right">
                            <div class="select is-info">
                                <select name="ht_selector" id='ht_selector' class="control level-item my_filter_select_width">
                                    <?php
                                        include(__DIR__ . "/part_pages/part_allteams_selector.php");
                                        // control variable below for the allteams selector to make one select menu change to two clubs
                                        $htSelectorIsSet = true;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="level ml-4">
                        <span for="filter_fixture_selector_checkbox" class="level-item level-left">Opposition :</span>
                        <div class="select is-info level-right">
                            <select name="at_selector" id="at_selector" class="level-item my_filter_select_width">
                                <?php
                                    include(__DIR__ . "/part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="level ml-4">
                        <span for="filter_season_selector" class="level-item level-left">Season :</span>
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

                    <div class="level ml-4">
                        <span for="filter_home_score" class="level-item level-left">Home Goals :</span>
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
                    <div class="level mx-4">
                        <span class="level-item level-left">Away Goals :</span>
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
                    <div class="level mx-4">
                        <span class="level-item level-left">Win Margin (Goals) :</span>
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
                    <div class="level mx-4">
                        <span class="level-item level-left">Month :</span>
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
                    <div class="level mx-4">
                        <span class="level-item level-left">Referee :</span>
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
                <div class="control column is-12 level my-0 pt-0">
                    <div class="level-item level-right">
                        <a type='button' href="page_advanced_search.php" class="m-2 button is-rounded is-danger">Reset</a>
                        <button type="submit" name='userfilter' id='userfilter_btn' class="m-2 button is-rounded is-danger">
                            <span class="icon is-left">
                                <i class="fas fa-search"></i>
                            </span>
                            <span>Find Match Results</span>    
                        </button>
                    </div>
                </div>
            </div>
        </form>
        </div>

        <!-- result total count bar -->
        <section class="column is-8 is-offset-2">
        <div class="level">
            <div class="level-left">
                <div>
                    <h1 class="title is-4 has-text-left m-3">Search results;</h1>
                    <p class="subtitle is-6 m-3 has-text-left">Click any result to view match details</p>
                </div>
            </div>
            <?php
                // modularized results bar
                require(__DIR__ . "/part_pages/part_num_results_bar.php"); 
            ?>
        </div>
            <!-- print out all match summaries as requested based on the final URL variable-->
            <?php require(__DIR__ . "/part_pages/part_print_summaries.php"); ?>
        </section>

    <section class="column is-8 is-offset-2">
        <?php require(__DIR__ . "/part_pages/part_pagination_bar_echo.php"); ?>
    </section>
    </div>

    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>

</html>