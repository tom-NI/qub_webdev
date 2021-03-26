<?php 
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
    require(__DIR__ . "/logic_files/single_match_logic.php");
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <title>EPL Match Result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-2">Match Result</h1>
            </div>
        </div>
    </section>

    <!-- main page starts here -->
        <div class='master_site_width'>
            <div class='mt-6 mx-4'>
                <div class='column is-desktop is-8 is-offset-2 is-12-mobile is-vcentered' >
                    <div class='container box columns is-centered my_box_border m-2 mb-5 p-3' >
                        <div class='columns level is-mobile is-centered'>
                            <div class='column is-narrow level-item'>
                                <div class='is-pulled-right'>
                                    <?php echo "<img class='image is-96x96 m-4 my_image_maintain_aspect' src='{$hometeamlogoURL}' alt='Home Logo'>"; ?>
                                </div>
                            </div>
                            <div class='column is-centered level-centre'>
                                <div class='is-centered is-vertical'>
                                    <p class='p-2 mx-1 is-size-7-mobile'> <?php echo "{$presentableMatchDate}"; ?> </p>
                                    <?php echo "{$kickoffParagraph}"; ?>
                                    <p class='p-2 mx-1 is-size-7-mobile'>Referee : <?php echo "{$refereename}"; ?> </p>
                                </div>
                            </div>
                            <div class='column is-narrow level-item'>
                                <?php echo "<img class='image is-96x96 m-4 my_image_maintain_aspect' src='{$awayteamlogoURL}' alt='Away Logo'>"; ?>
                            </div>
                        </div>
                    </div>
                <div class='container box column is-centered my_box_border m-2 mb-5 mt-5 p-1'>
                    <div class='columns is-mobile is-vcentered is-centered'>
                        <div class='column'>
                            <h4 class='is-size-5 is-size-6-mobile has-text-right mx-3'><b> <?php echo "{$hometeam}"; ?></b>
                            </h4>
                        </div>
                        <div class='column level is-narrow m-3 mt-6 p-0'>
                            <div class='my_inline_divs result_box level-left'>
                                <p class='column is-size-5 is-size-6-mobile level-item p-1'> <?php echo "{$hometeamtotalgoals}"; ?></p>
                            </div>
                            <div class='my_inline_divs level-centre'>
                                <h4 class='level-item mx-2'>vs.</h4>
                            </div>
                            <div class='my_inline_divs result_box level-right'>
                                <p class='is-size-5 column is-size-6-mobile level-item p-1'> <?php echo "{$awayteamtotalgoals}"; ?></p>
                            </div>
                            <p class='m-2 subtitle is-6'>Full Time</p>
                        </div>
                        <div class='column'>
                            <h4 class='is-size-5 is-size-6-mobile has-text-left mx-3'><b> <?php echo "{$awayteam}"; ?><b></h4>
                        </div>
                    </div>
                </div>
                <?php
                    // add in a box for an admin to administrate this match if signed in as a user
                    if (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] === "admin") {
                        $postedMatchID = htmlentities(trim($_GET['num']));
                        echo "
                            <div class='level is-centered my_grey_highlight_para p-5'>
                                <div class='level-item level-left'>
                                    <p class='mx-3 subtitle is-5'>Administrate this result :</p>
                                </div>
                                <div class='level-item level-right'>
                                    <a href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/admin_cms/cms_edit_match.php?num={$postedMatchID}'>
                                        <button class='mx-3 button is-rounded is-info'>
                                            <span class='icon is-left'>
                                                <i class='fas fa-pen'></i>
                                            </span>
                                            <span>Edit Match</span>
                                        </button>
                                    </a>
                                    <a href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/logic_files/delete_match_logic.php?deletematch&num={$postedMatchID}'>
                                        <button id='delete_match_btn' class='mx-3 button is-rounded is-info'>
                                            <span class='icon is-left'>
                                                <i class='fas fa-trash'></i>
                                            </span>
                                            <span>Delete Match</span>
                                        </button>
                                    </a>
                                </div>
                            </div>";
                        }
                ?>

                <!-- single match chart -->
                <div id='my_comparison_stat_list' class='mt-4'>
                    <div class='column' id='match_stat_chart'></div>
                </div>

                <!-- div with a button for fixture analysis -->
                <div class='level is-mobile is-centered my_grey_highlight_para p-4 mt-6'>
                    <div class="level-item level-left p-4 pb-0 ml-4">
                        <h2 class='is-size-4 has-text-weight-semibold'>Full fixture analysis</h2>
                    </div>
                    <form action="page_fixture_analysis.php?" method='GET' class='level-item level-right'>
                        <input type="hidden" name='ht_selector' value=<?php echo $homeTeamSearched ?>>
                        <input type="hidden" name='at_selector' value=<?php echo $awayTeamSearched ?>>
                        <input type="hidden" name='strict' value='on'>
                        <button type='submit' class='mx-3 button is-rounded is-danger is-narrow mr-5'>
                            <span class="material-icons">insights</span>
                            <span class='ml-2'>Analyse this fixture</span>
                        </button>
                    </form>
                </div>

                <!-- historic fixtures section -->
                <div id='my_comparison_stat_list' class='my-6'>
                    <div class='my_info_colour'>
                        <?php
                            echo "<h2 class='title is-4 pt-5 mb-2 my_info_colour'>{$hometeam} vs {$awayteam} - Recent Fixture Analysis</h2>";
                        ?>
                        <p class='px-6 pt-3 my_info_colour'>Draw a Graph of Premier League match statistics (including the reverse fixture) for five previous meetings</p>
                        <div class='level py-5'>
                            <div class='level-item'>
                                <p>Select a statistic to compare :</p>
                            </div>
                            <form class='level-item form p-0'
                                action="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_single_match_result.php?num=<?php echo "$postedMatchID" ?>" 
                                method='POST'>
                                <div class='level-item control has-icons-left'>
                                    <div class='level-item select is-info'>
                                        <select class='level-item' name='analyzed_statistic'>
                                            <?php
                                                require(__DIR__ . "/part_pages/part_stat_selector.php");
                                            ?>
                                        </select>
                                    </div>
                                    <div class="icon is-left">
                                        <i class="far fa-chart-bar"></i>
                                    </div>
                                </div>
                                <button name='change_stat_btn' class='ml-5 level-item button is-danger'>Go</button>
                            </form>
                        </div>
                    </div>
                </div>
                    
                    <!-- historic results section with selector -->
                    <?php
                        // only draw the graph if there are previous results to show, otherwise show warning
                        if ($noPreviousMatchesToShow) {
                            echo "<div class='my-3 p-5 has-background-warning'>
                                    <h3 class='is-size-5 has-text-weight-semibold'>No Previous Matches exist for Statistic Chart</h3>
                                </div>";
                        } else {
                            echo"
                            <div class='mt-4 column'>
                                <h3 class='title is-4 mt-3'>Statistics for preceding {$previousMatchCount} matches</h3>
                                <p class='title is-5 mb-0 pb-0'>{$statToAnalyze} between {$hometeam} and {$awayteam}</p>
                                <div class='column' id='former_fixtures_chart'></div>
                            </div>";
                            include_once(__DIR__ . "/charts/chart_past_fixture.php");
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include(__DIR__ . '/part_pages/part_site_footer.php'); ?>
    <script src="scripts/my_script.js"></script>

    <!-- Single Match information -->
    <?php include_once(__DIR__ . "/charts/chart_single_match_stats.php") ?>
</body>
</html>