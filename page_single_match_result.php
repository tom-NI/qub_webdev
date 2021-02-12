<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script defer src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/match_bar_chart.js"></script>
    <title>EPL Match Result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Match Result</h1>
            </div>
        </div>
    </section>

    <!-- main page starts here -->
    <div class="master_site_width">
        <div class="mt-6 mx-4">
            <div class="column is-desktop is-8 is-offset-2 is-12-mobile is-vcentered">
                <div class="container box columns is-centered my_box_border m-2 mb-5 p-3">
                    <div class="columns level is-mobile is-centered">
                        <div class="column is-narrow level-item">
                            <div class="is-pulled-right">
                                <img class="image is-64x64 m-4 my_image_maintain_aspect" src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/mufc.jpg"
                                    alt="Home Logo">
                            </div>
                        </div>
                        <div class="column is-centered level-centre">
                            <div class="is-centered is-vertical">
                                <p class="p-2 mx-1 is-size-7-mobile">Match Date : 25 September 2020</p>
                                <p class="p-2 mx-1 is-size-7-mobile">Kick Off 18:00</p>
                                <p class="p-2 mx-1 is-size-7-mobile">Referee : M. Dean</p>
                            </div>
                        </div>
                        <div class="column is-narrow level-item">
                            <img class="image is-64x64 m-4 my_image_maintain_aspect"
                                src="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/images/newcastle_united_logo.jpg" alt="Away Logo">
                        </div>
                    </div>
                </div>
                <div class="container box column is-centered my_box_border m-2 mb-5 mt-5 p-1">
                    <div class="columns is-mobile is-vcentered is-centered">
                        <div class="column">
                            <h4 class="is-size-5 is-size-6-mobile has-text-right mx-3"><b>Manchester United</b>
                            </h4>
                        </div>
                        <div class="column level is-narrow m-3 mt-6 p-0">
                            <div class="my_inline_divs result_box level-left">
                                <p class="column is-size-5 is-size-6-mobile level-item p-1">3</p>
                            </div>
                            <div class="my_inline_divs level-centre">
                                <h4 class="level-item mx-2">vs.</h4>
                            </div>
                            <div class="my_inline_divs result_box level-right">
                                <p class="is-size-5 column is-size-6-mobile level-item p-1">0</p>
                            </div>
                            <p class="m-2 subtitle is-7">Full Time</p>
                        </div>
                        <div class="column">
                            <h4 class="is-size-5 is-size-6-mobile has-text-left mx-3"><b>Newcastle United</b></h4>
                        </div>
                    </div>
                </div>

                <!-- Javascript injected chart! -->
                <div id="my_comparison_stat_list" class="mt-6">
                    <div class="column" id="match_stat_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <?php include("site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>