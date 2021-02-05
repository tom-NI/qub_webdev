<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <title>Advanced Search</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif	">
    <!-- Full nav bar -->
    <?php include("site_navbar.php"); ?>

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


            <a href="single_match_result.html">
                <div id="master_result_card" class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div>
                        <p class="is-size-6 mt-3 is-size-7-mobile">Match Date : 25 September
                            2020</p>
                    </div>
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <div class="is-pulled-right">
                                <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                    src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/mufc.jpg"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-right is-narrow">
                                <b>Manchester United</b>
                            </h4>
                        </div>
                        <div class="column level mt-4 is-narrow">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 is-size-6-mobile level-item p-1">1</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2 is-size-7-mobile">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 is-size-6-mobile column level-item p-1">0</p>
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-left is-narrow">
                                <b>Newcastle United</b>
                            </h4>
                        </div>
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/newcastle_united_logo.jpg"
                                alt="Away Logo">
                        </div>
                    </div>
                </div>
            </a>
            <a href="single_match_result.html">
                <div id="master_result_card" class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div>
                        <p class="is-size-6 mt-3 is-size-7-mobile">Match Date : 25 September
                            2020</p>
                    </div>
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <div class="is-pulled-right">
                                <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                    src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/manchester-city-logo.png"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-right is-narrow">
                                <b>Manchester City</b>
                            </h4>
                        </div>
                        <div class="column level mt-4 is-narrow">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 level-item is-size-6-mobile p-1">3</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2 is-size-7-mobile">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 column level-item is-size-6-mobile p-1">0</p>
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-left is-narrow">
                                <b>Arsenal</b>
                            </h4>
                        </div>
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/arsenal_logo.png"
                                alt="Away Logo">
                        </div>
                    </div>
                </div>
            </a>
            <a href="single_match_result.html">
                <div id="master_result_card" class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div>
                        <p class="is-size-6 mt-3 is-size-7-mobile">Match Date : 25 September
                            2020</p>
                    </div>
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <div class="is-pulled-right">
                                <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                    src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/wolverhampton_wanderers.png"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-right is-narrow">
                                <b>Wolves</b>
                            </h4>
                        </div>
                        <div class="column level mt-4 is-narrow">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 level-item is-size-6-mobile p-1">0</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2 is-size-7-mobile">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 column level-item is-size-6-mobile p-1">4</p>
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-left is-narrow">
                                <b>Tottenham Hotspur</b>
                            </h4>
                        </div>
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/tottenham_hotspur_logo.jpg"
                                alt="Away Logo">
                        </div>
                    </div>
                </div>
            </a>
            <a href="single_match_result.html">
                <div id="master_result_card" class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div>
                        <p class="is-size-6 mt-3 is-size-7-mobile">Match Date : 25 September
                            2020</p>
                    </div>
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <div class="is-pulled-right">
                                <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                    src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/liverpool_fc.jpg"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-right is-narrow">
                                <b>Liverpool</b>
                            </h4>
                        </div>
                        <div class="column level mt-4 is-narrow">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 level-item is-size-6-mobile p-1">2</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2 is-size-7-mobile">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 column level-item is-size-6-mobile p-1">1</p>
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-left is-narrow">
                                <b>West Ham</b>
                            </h4>
                        </div>
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/west_ham_united_fc_logo.jpg"
                                alt="Away Logo">
                        </div>
                    </div>
                </div>
            </a>
            <a href="single_match_result.html">
                <div id="master_result_card" class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div>
                        <p class="is-size-6 mt-3 is-size-7-mobile">Match Date : 25 September
                            2020</p>
                    </div>
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <div class="is-pulled-right">
                                <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                    src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/chelsea_fc.jpg"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-right is-narrow">
                                <b>Chelsea</b>
                            </h4>
                        </div>
                        <div class="column level mt-4 is-narrow">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 level-item is-size-6-mobile p-1">1</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2 is-size-7-mobile">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 column level-item is-size-6-mobile p-1">0</p>
                            </div>
                        </div>
                        <div class="column">
                            <h4 class="is-size-6 is-size-6-mobile has-text-left is-narrow">
                                <b>Leicester</b>
                            </h4>
                        </div>
                        <div class="column is-2 is-hidden-mobile is-narrow">
                            <img class="image is-48x48 m-1 mb-5 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/Leicester-City-logo.png"
                                alt="Away Logo">
                        </div>
                    </div>
                </div>
            </a>
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
            <form action="GET">
                <ul>
                    <div>
                        <p class="subtitle my-4">Filter Results:</p>
                    </div>
                    <div class="field my_grey_border p-2">
                        <div class="level field">
                            <div class="level-left">
                                <input class="checkbox level-item" type="checkbox" name="club_checkbox"
                                    id="filter_club_name_checkbox">
                                <label for="filter_club_name_checkbox" class="label level-item is-small">Club</label>
                            </div>
                            <div class="level-right">
                                <div class="select is-info is-small">
                                    <select class="my_filter_select_width control is-small level-item">
                                        <option value="placeholder_team_a">team A</option>
                                        <option value="placeholder_team_b">team B</option>
                                        <option value="placeholder_team_b">team C</option>
                                        <option value="placeholder_team_b">etc</option>
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
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_season_checkbox"
                                name="filter_season_checkbox">
                            <label class="label is-small level-item" for="filter_season_checkbox">Season</label>
                        </div>
                        <div class="level-right">
                            <div class="select is-info is-small">
                                <select name="" id="filter_season_selector" class="level-item" select control is-small">
                                    <option value="2020-2021_placeholder">2020-2021</option>
                                    <option value="2019-2020_placeholder">2019-2020</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="field is-small level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox"
                                id="filter_fixture_selector_checkbox">
                            <label for="filter_fixture_selector_checkbox"
                                class="label is-small level-item">Fixture</label>
                        </div>
                        <div class="select is-info is-small level-right">
                            <select name="season_selector" id="season_selector"
                                class="my_filter_select_width select level-item">
                                <option value="opp1_placeholder">Opposition Team placeholder</option>
                                <option value="opp2_placeholder">Opposition Team placeholder</option>
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
                                <input type="number" id="filter_home_score" placeholder="0" min="0" max="20"
                                    class="my_filter_num_entry input is-small is-info level-item">
                            </div>
                            <p class="mx-1"> : </p>
                            <div class="control">
                                <input type="number" id="filter_away_score" placeholder="0" min="0" max="20"
                                    class="my_filter_num_entry input is-small is-info level-item">
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="is-small checkbox level-item" type="checkbox" id="filter_win_margin_checkbox">
                            <label for="filter_win_margin_checkbox" class="label is-small level-item">Win Margin
                                (goals)</label>
                        </div>
                        <div class="level-right">
                            <input class="input level-item my_filter_num_entry is-info is-small" type="number"
                                placeholder="0" min="1" max="20" id="filter_win_margin_user_input">
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
                                    <option value="month_selector_january">January</option>
                                    <option value="month_selector_february">February</option>
                                    <option value="month_selector_march">March</option>
                                    <option value="month_selector_april">April</option>
                                    <option value="month_selector_may">May</option>
                                    <option value="month_selector_june">June</option>
                                    <option value="month_selector_july">July</option>
                                    <option selected value="month_selector_aug">August</option>
                                    <option value="month_selector_sept">September</option>
                                    <option value="month_selector_oct">October</option>
                                    <option value="month_selector_nov">November</option>
                                    <option value="month_selector_dec">December</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="field level">
                        <div class="level-left">
                            <input class="checkbox is-small level-item" type="checkbox" id="filter_day_search_checkbox">
                            <label for="filter_day_search_checkbox" class="label is-small level-item">Day</label>
                        </div>
                        <div class="select is-info is-small level-right">
                            <div class="select">
                                <select name="" id="filter_day_selector" class="my_filter_select_width level-item">
                                    <option value="day_selector_mon">Monday</option>
                                    <option value="day_selector_tues">Tuesday</option>
                                    <option value="day_selector_wed">Wednesday</option>
                                    <option value="day_selector_thurs">Thursday</option>
                                    <option value="day_selector_fri">Friday</option>
                                    <option selected value="day_selector_sat">Saturday</option>
                                    <option value="day_selector_sun">Sunday</option>
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
                            <select name="referee_selector" id="filter_referee_selector"
                                class="my_filter_select_width select">
                                <option value="referee_name_1">Ref 1</option>
                                <option value="referee_name_2">Ref 2</option>
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

    <?php include("site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>