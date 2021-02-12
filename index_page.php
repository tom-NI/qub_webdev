<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyles.css">
    <title>EPL Match Statistic Finder</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">

    <!-- Full nav bar -->
    <?php include("site_navbar.php"); ?>

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
                    <form action="" method="get">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input is-rounded" type="text" placeholder="Search for clubs to view results"
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
                    <p class="mb-5 m-2"><a href="advanced_search.html">Advanced Match Search</a></p>
                </div>
            </div>

            <!-- image carousel! -->
            <div class="my_image_maintain_aspect">
                <figure>
                    <img src="https://i.imgur.com/Ok815ec.jpg" alt=""
                        class="box">
                    <caption>
                        Manchester United and Liverpool are neck and neck this season in the
                        title race
                    </caption>
                </figure>
            </div>

            <h3 class="title is-4 m-3 mt-6">Most recent Premier League results;</h3>
            <p class="subtitle is-6 m-3">Click any result to view match details</p>

            <!-- past 5 premier league match results -->
            <!-- remember to give the top card mt-6 -->
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

        <!-- stat tiles section -->
        <section class="section column container my_grey_highlight_para mx-5">
            <div class="container">
                <h3 class="title is-4 mb-5">StatTiles</h3>
                <h4 class="subtitle is-6 pb-2">Season : 2020-2021</h4>
            </div>
            <div class="tile is-ancestor is-vertical is-10-mobile">
                <div class="tile is-12 pt-5">
                    <p>Consistency:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Tottenham Hotspur</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon">keyboard_arrow_down</i>
                                <p class="subtitle">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Manchester United</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon">keyboard_arrow_up</i>
                                <p class="subtitle">9</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tile is-12">
                    <p>Goals Scored:</p>
                </div>
                <div class="tile is-12 level is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-2">Liverpool</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">4</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-2">Newcastle United</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">65</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Goals Conceded:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Sheffield United</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">32</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Bournemouth</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">4</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Shots:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Crystal Palace</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">18</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Arsenal</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">74</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Shots on Target:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Crystal Palace</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">12</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Manchester United</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">47</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Corners:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Brighton</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">2</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Leicester City</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">32</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tile is-12">
                    <p>Fouls:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Tottenham Hotspur</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">56</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Man City</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">97</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Yellow Cards:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Tottenham Hotspur</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">13</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Liverpool FC</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">34</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="tile is-12">
                    <p>Red Cards:</p>
                </div>
                <div class="tile is-12 is-parent">
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Tottenham Hotspur</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons redicon my_red_colour">keyboard_arrow_down</i>
                                <p class="subtitle">0</p>
                            </div>
                        </div>
                    </div>
                    <div class="my_inline_divs tile is-child is-6 box level">
                        <div class="level-left level-item my_level_wrap">
                            <p class="has-text-left p-1">Manchester United</p>
                        </div>
                        <div class="level-right">
                            <div>
                                <i class="material-icons greenicon my_red_colour">keyboard_arrow_up</i>
                                <p class="subtitle">3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <?php include("site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>