<?php 
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");

    // set the requested stat from the user, else default to goals
    if (isset($_POST['stattile_statistic'])) {
        $statToAnalyze = htmlentities(trim($_POST['stattile_statistic']));
    } else {
        $statToAnalyze = "Goals";
    }

    // get the requested season data from the user, else default to the current season and retrieve it!
    if (isset($_POST['season_pref'])) {
        $season = htmlentities(trim($_POST['season_pref']));
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$season}";
    } else {
        $season = getCurrentSeason();
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$season}";
    }
    $seasonAPIdata = postDevKeyInHeader($seasonInfoURL);
    $seasonGameList = json_decode($seasonAPIdata, true);

    $goalsConcededStatisticRequested = false;

    // get the JSON statistic keys based only on the info requested by the user
    switch ($statToAnalyze) {
        case "Goals":
            $homeStatKey = 'hometeamtotalgoals';
            $awayStatKey = 'awayteamtotalgoals';
            break;
        case "Goals Conceded":
            $goalsConcededStatisticRequested = true;
            $homeStatKey = 'awayteamtotalgoals';
            $awayStatKey = 'hometeamtotalgoals';
            break;
        case "Shots":
            $homeStatKey = 'hometeamshots';
            $awayStatKey = 'awayteamshots';
            break;
        case "Shots On Target":
            $homeStatKey = 'hometeamshotsontarget';
            $awayStatKey = 'awayteamshotsontarget';
            break;
        case "Corners":
            $homeStatKey = 'hometeamcorners';
            $awayStatKey = 'awayteamcorners';
            break;
        case "Fouls":
            $homeStatKey = 'hometeamfouls';
            $awayStatKey = 'awayteamfouls';
            break;
        case "Yellow Cards":
            $homeStatKey = 'hometeamyellowcards';
            $awayStatKey = 'awayteamyellowcards';
            break;
        case "Red Cards":
            $homeStatKey = 'hometeamredcards';
            $awayStatKey = 'awayteamredcards';
            break;
        default :
            $homeStatKey = 'hometeamtotalgoals';
            $awayStatKey = 'awayteamtotalgoals';
            break;
    }

    // array to hold the full seasons stats (assoc array, clubname is the key)
    $statisticArray = array();
    
    foreach($seasonGameList as $match) {
        $homeTeam = $match['hometeam'];
        $awayTeam = $match['awayteam'];

        if (!array_key_exists($homeTeam, $statisticArray)) {
            $statisticArray[$homeTeam] = 0;
        }
        if (!array_key_exists($awayTeam, $statisticArray)) {
            $statisticArray[$awayTeam] = 0;
        }
        $statisticArray[$homeTeam] += (int)$match[$homeStatKey];
        $statisticArray[$awayTeam] += (int)$match[$awayStatKey];
    }
    // sort the array to get the highest value first, then in desc order!
    arsort($statisticArray);
    
    // build the subarray for titles etc, add to the main chart data array
    $headersArray = array();
    array_push($headersArray, "Club", $statToAnalyze);
    
    // add the headers needed by JS graph to the final sorted Graph array
    $finalSortedGraphArray = array();
    $finalSortedGraphArray[] = $headersArray;

    foreach ($statisticArray as $key => $value) {
        $tempArray = array();
        array_push($tempArray, $key, $value);
        $finalSortedGraphArray[] = $tempArray;
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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <title>EPL Match Result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include(__DIR__ . "/part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-2">Chart Past Season Statistics</h1>
                
            </div>
        </div>
    </section>

        <div class='master_site_width'>
            <div class='column is-desktop is-8 is-offset-2 is-12-mobile is-vcentered my_info_colour mt-4 p-5'>
                <p class='my_info_colour title is-5'>Select Season and Statistic to customise the chart</p>
                <form class='level-item form' action="page_chart_season.php" method='POST'>
                    <div class='select level-item'>
                        <select name="season_pref" id="season_chart_select">
                            <?php
                                require(__DIR__ . "/part_pages/part_season_select.php");
                            ?>
                        </select>
                    </div>
                    <div class='level-item control has-icons-left mx-4'>
                        <div class='level-item select is-info'>
                            <select class='level-item' name='stattile_statistic'>
                                <?php
                                    require(__DIR__ . "/part_pages/part_stattiles_stats_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class="icon is-left">
                            <i class="far fa-chart-bar"></i>
                        </div>
                    </div>
                    <button name='change_statistic' class='ml-5 level-item button is-danger is-rounded'>Draw Chart</button>
                </form>
            </div>

            <!-- chart div -->
            <div id='my_comparison_stat_list' class='mt-4'>
                <h3 class="title is-4 mt-6"><?php echo "{$season}" ?> Season Analysis Chart</h3>
                <p class="title is-5 mb-0 pb-0">Total <?php echo "{$statToAnalyze}"; ?></p>
                <div class='column' id='season_analysis_chart'></div>
            </div>
        </div>
    </div>
    <?php include(__DIR__ . '/part_pages/part_site_footer.php'); ?>
    <?php include_once(__DIR__ . "/charts/chart_season_analysis.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>
</html>