<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fixture Analysis</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Fixture Analysis</h1>
                <p class="subtitle is-5 mt-1">Select teams to analyse all previous meetings</p>
            </div>
        </div>
    </section>

    <!-- main site content -->
    <div class="master_site_width">
        <section class="columns is-mobile is-vcentered m-2 mx-5 pt-4">
            <div class="column is-8-desktop is-offset-2-desktop my_info_colour">
                <div class="column p-4 mx-3">
                    <form class="level columns form">
                        <div class="column level-item">
                            <div class="select control is-expanded is-success">
                                <select name="" id="fixture_ht_selector" class="">
                                    <option default value="">Select Home Team</option>
                                    <option value="">Team 1</option>
                                    <option value="">Team 2</option>
                                    <option value="">Team 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="column level-item">
                            <div class="select control is-expanded is-danger">
                                <select name="" id="fixture_at_selector" class="">
                                    <option default value="">Select Away Team</option>
                                    <option value="">Team 1</option>
                                    <option value="">Team 2</option>
                                    <option value="">Team 3</option>
                                </select>
                            </div>
                        </div>
                        <div class="column is-centered mt-0 level-item">
                            <div class="m-1">
                                <button type="submit" id="fixture_search_btn" class="button is-rounded is-danger">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <div class="column is-8 is-offset-2 my_sticky_div">
            <div class="container column box is-centered my_sticky_div py-4 mx-5">
                <div class="columns is-mobile is-vcentered is-centered">
                    <div class="column">
                        <h4 class="is-size-4 is-size-5-mobile has-text-right team_a_name_colour"><b>Manchester
                                United</b>
                        </h4>
                    </div>
                    <div class="column level is-narrow mt-5">
                        <h4 class="level-item">vs.</h4>
                    </div>
                    <div class="column">
                        <h4 class="is-size-4 is-size-5-mobile has-text-left team_b_name_colour"><b>Newcastle United</b>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="master_site_width columns is-desktop ">
            <section class="column is-centered is-offset-one-fifth mx-5">
                <!-- main stat section of the page -->
                <div class="columns level my-2 mt-5">
                    <h2 class="title is-4">Key Statistics:</h2>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="image is-24x24 ml-5">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="column is-half">
                        <p class="subtitle is-6 has-text-left ml-3">Past meetings</p>
                    </div>
                    <div class="column my_info_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-5 m-0 my_stat_font is-one-fifth" id="fixture_total_meets_amount"><b>87</b>
                        </p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="image is-24x24 ml-5">
                        <i class="fas fa-equals"></i>
                    </div>
                    <div class="column is-half">
                        <p class="subtitle is-6 has-text-left ml-3">Total draws</p>
                    </div>
                    <div class="column my_info_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-5 m-0 my_stat_font is-one-fifth" id="fixture_total_meets_amount"><b>14</b>
                        </p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="image is-24x24 ml-5">
                        <i class="far fa-futbol"></i>
                    </div>
                    <div class="column is-half">
                        <p class="subtitle is-6 has-text-left  ml-3">Average total goals per game</p>
                    </div>
                    <div class="column my_info_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-5 m-0 my_stat_font is-one-fifth" id="fixture_av_goals_amount"><b>2.8</b>
                        </p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="image is-24x24 ml-5">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="column is-half">
                        <p class="subtitle is-6 has-text-left ml-3">Average total shots per game</p>
                    </div>
                    <div class="column my_info_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-5 m-0 my_stat_font" id="fixture_av_goals_amount"><b>12.5</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="image is-24x24 ml-5">
                        <span class="material-icons">sports</span>
                    </div>
                    <div class="column is-half">
                        <p class="subtitle is-6 has-text-left ml-3">Average total fouls per game</p>
                    </div>
                    <div class="column my_info_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-5 m-0 my_stat_font" id="fixture_av_goals_amount"><b>23.5</b></p>
                    </div>
                </div>


                <div class="columns level my-2 mt-6">
                    <h2 class="title is-4 ">Highest all Time statistics by match:</h2>
                </div>

                <!-- most goals scored -->
                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_a_goals_amount"><b>4</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_a_goals_scored_date">31/07/2020</p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Goals Scored</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_b_goals_amount"><b>7</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_b_goals_scored_date">31/08/2020</p>
                    </div>
                </div>

                <!-- most shots on goal -->
                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_a_shots_amount"><b>4</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_a_shots_date">31/07/2020</p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Shots on Goal</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_b_shots_amount"><b>7</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_b_shots_date">31/09/2020</p>
                    </div>
                </div>

                <!-- most fouls -->
                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_a_fouls_amount"><b>4</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_a_fouls_date">31/07/2020</p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Fouls</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_b_fouls_amount"><b>7</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_b_fouls_date">31/09/2020</p>
                    </div>
                </div>

                <!-- yellow cards -->
                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_a_yellow_cards_amount"><b>4</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_a_yellow_cards_date">31/07/2020</p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Yellow Cards</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_b_yellow_cards_amount"><b>7</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_b_yellow_cards_date">31/09/2020</p>
                    </div>
                </div>

                <!-- red cards -->
                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_a_red_cards_amount"><b>4</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_a_red_cards_date">31/07/2020</p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Red Cards</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font" id="team_b_red_cards_amount"><b>7</b></p>
                        <p class="m-0 mt-1 subtitle is-7 my_stat_font" id="team_b_red_cards_date">31/09/2020</p>
                    </div>
                </div>
            </section>

            <section class="column mx-5">
                <!-- title  -->
                <div class="columns level my-2 mt-5">
                    <h2 class="title is-4">Metric Comparison:</h2>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>41%</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Percentage wins</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>34%</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>37</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Win count</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>12</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>3.2%</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">% Clean Sheets</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>8.3%</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>4%</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Games Won by Half Time</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>21%</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>1.2</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Goals per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>3.2</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>5.4</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Shots per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>13.2</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>3.2</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Shots on target</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>8.3</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>5</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Clean Sheets</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>12</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>8.2</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Average corners per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>9.7</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>9.3</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Fouls per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>8.1</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>2.7</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Yellow Cards per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>3.1</b></p>
                    </div>
                </div>

                <div class="columns is-vcentered is-mobile level m-4 my_fixture_stat_level">
                    <div class="column team_a_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>0.1</b></p>
                    </div>
                    <div class="column is-one-third">
                        <p class="subtitle is-6">Red Cards per game</p>
                    </div>
                    <div class="column team_b_colour box my_dont_wrap_text m-3 mx-5">
                        <p class="subtitle is-6 m-0 my_stat_font"><b>0.3</b></p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include("site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>