<?php
    include_once("allfunctions.php");
?>

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
    <?php include("part_site_navbar.php"); ?>

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

            <!-- 5 most recent premier league match results -->
            <?php
                $recentMatchesURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?match_summaries&count=5";
                $recentMatchesAPIData = file_get_contents($recentMatchesURL);
                $recentMatchesList = json_decode($recentMatchesAPIData, true);

                foreach ($recentMatchesList as $summary) {
                    $matchDate = $summary['matchdate'];
                    $homeTeam = $summary['hometeam'];
                    $awayTeam = $summary['awayteam'];
                    $homeScore = $summary['homescore'];
                    $awayScore = $summary['awayscore'];
                    $homeLogo = $summary['hometeamlogoURL'];
                    $awayLogo = $summary['awayteamlogoURL'];

                    // make the date decent looking!
                    $finalMatchDate = parseDateLongFormat($matchDate);

                        echo "
                        <a type='form' method='GET' href='page_single_match_result.php'>
                        <div id='master_result_card' class='container box column is-centered my_box_border m-2 mb-5 mt-5 p-1'>
                            <div>
                                <p class='is-size-6 mt-3 is-size-7-mobile'>{$finalMatchDate}</p>
                            </div>
                            <div class='columns is-mobile is-vcentered is-centered'>
                                <div class='column is-2 is-hidden-mobile is-narrow'>
                                    <div class='is-pulled-right'>
                                        <img class='image is-48x48 m-1 mb-5 my_image_maintain_aspect'
                                            src='{$homeLogo}'
                                            alt='Home Logo'>
                                    </div>
                                </div>
                                <div class='column'>
                                    <h4 class='is-size-6 is-size-6-mobile has-text-right is-narrow'>
                                        <b>{$homeTeam}</b>
                                    </h4>
                                </div>
                                <div class='column level mt-4 is-narrow'>
                                    <div class='my_inline_divs result_box level-left'>
                                        <p class='column is-size-5 is-size-6-mobile level-item p-1'>{$homeScore}</p>
                                    </div>
                                    <div class='my_inline_divs level-centre'>
                                        <h4 class='level-item mx-2 is-size-7-mobile'>vs.</h4>
                                    </div>
                                    <div class='my_inline_divs result_box level-right'>
                                        <p class='is-size-5 is-size-6-mobile column level-item p-1'>{$awayScore}</p>
                                    </div>
                                </div>
                                <div class='column'>
                                    <h4 class='is-size-6 is-size-6-mobile has-text-left is-narrow'>
                                        <b>{$awayTeam}</b>
                                    </h4>
                                </div>
                                <div class='column is-2 is-hidden-mobile is-narrow'>
                                    <img class='image is-48x48 m-1 mb-5 my_image_maintain_aspect'
                                        src='{$awayLogo}'
                                        alt='Away Logo'>
                                </div>
                            </div>
                        </div>
                    </a>";
                }
            ?>
        </section>

        <!-- stat tiles section -->
        <section class="section column container my_grey_highlight_para mx-5">
            <div class="container">
                <h3 class="title is-4 mb-5">StatTiles</h3>
            </div>
            <div class="container">
                <form action="GET" class="level mb-3">
                    <div class="p-2 level-item">
                        <label for="season_select"><b>Select Season :</b></label>
                    </div>
                    <div class="select control is-expanded is-link level-item">
                        <select name="season_pref" id="season_select">
                            <?php
                                require("part_season_select.php");
                            ?>
                        </select>
                    </div>
                    <div class="level-item">
                        <button class="button is-info">Go</button>
                    </div>
                </form>
            </div>
            <div class="tile is-ancestor is-vertical is-10-mobile">
                <?php
                    
                    if (isset($_GET['season_pref'])) {
                        $season = $_GET['season_pref'];
                        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?full_matches&fullseason={$season}";
                    } else {
                        $currentMaxSeasonInDB = getCurrentSeason();
                        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?full_matches&fullseason={$currentMaxSeasonInDB}";
                    }
                    $seasonAPIdata = file_get_contents($seasonInfoURL);
                    $seasonGameList = json_decode($seasonAPIdata, true);
                
                    // add all the club names into an array of current season teams
                    $allSeasonClubNames = array();
                
                    // store every metric to be measured in an array
                    $consistency = array();
                    $allGoals = array();
                    $allConceded = array();
                    $allShots = array();
                    $allShotsOT = array();
                    $allCorners = array();
                    $allFouls = array();
                    $allYellowCards = array();
                    $allRedCards = array();
                
                    foreach($seasonGameList as $singleMatch) {
                        $homeTeamName = $singleMatch["hometeam"];
                        $awayTeamName = $singleMatch["awayteam"];
                
                        // check if the team is in the season clubs, if not add.
                        // always return the index to use later
                        if (array_search($homeTeamName, $allSeasonClubNames)) {
                            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
                            echo $homeTeamIndex;
                        } else {
                            $allSeasonClubNames[] = $homeTeamName;
                            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
                        }
                        if (array_search($awayTeamName, $allSeasonClubNames)) {
                            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
                            echo $awayTeamIndex;
                        } else {
                            $allSeasonClubNames[] = $awayTeamName;
                            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
                        }
                
                        $allgoals[$homeTeamIndex] += $singleMatch["hometeamtotalgoals"];
                        $allConceded[$awayTeamIndex] += $singleMatch["hometeamtotalgoals"];
                        $allShots[$homeTeamIndex] += $singleMatch["hometeamshots"];
                        $allShotsOT[$homeTeamIndex] += $singleMatch["hometeamshotsontarget"];
                        $allCorners[$homeTeamIndex] += $singleMatch["hometeamcorners"];
                        $allFouls[$homeTeamIndex] += $singleMatch["hometeamfouls"];
                        $allYellowCards[$homeTeamIndex] += $singleMatch["hometeamyellowcards"];
                        $allRedCards[$homeTeamIndex] += $singleMatch["hometeamredcards"];
                
                        $allgoals[$awayTeamIndex] += $singleMatch["awayteamtotalgoals"];
                        $allConceded[$homeTeamIndex] += $singleMatch["awayteamtotalgoals"];
                        $allShots[$awayTeamIndex] += $singleMatch["awayteamshots"];
                        $allShotsOT[$awayTeamIndex] += $singleMatch["awayteamshotsontarget"];
                        $allCorners[$awayTeamIndex] += $singleMatch["awayteamcorners"];
                        $allFouls[$awayTeamIndex] += $singleMatch["awayteamfouls"];
                        $allYellowCards[$awayTeamIndex] += $singleMatch["awayteamyellowcards"];
                        $allRedCards[$awayTeamIndex] += $singleMatch["awayteamredcards"];
                    }

                    // every tile data array is in the order;
                    // tile name, lowest value, highest value, lowest team, highest team
                    $allGoalsTileData = array();
                    $allConcededTileData = array();
                    $allShotsTileData = array();
                    $allShotsOTTileData = array();
                    $allCornersTileData = array();
                    $allFoulsTileData = array();
                    $allYellowCardsTileData = array();
                    $allRedCardsTileData = array();

                    // main tile array to be looped thru
                    $masterArray = array();
                
                    $allGoalsTileData[] = "Goals Scored";
                    $allGoalsTileData[] = max($allGoals);
                    $allGoalsTileData[] = min($allGoals);
                    $allGoalsTileData[] = findMaxValueAndReturnTeam($allGoals ,$allSeasonClubNames);
                    $allGoalsTileData[] = findMinValueAndReturnTeam($allGoals ,$allSeasonClubNames);
                    $masterArray[] = $allGoalsTileData;
                
                    $allConcededTileData[] = "Goals Conceded";
                    $allConcededTileData[] = min($allConceded);
                    $allConcededTileData[] = max($allConceded);
                    $allConcededTileData[] = findMinValueAndReturnTeam($allConceded ,$allSeasonClubNames);
                    $allConcededTileData[] = findMaxValueAndReturnTeam($allConceded ,$allSeasonClubNames);
                    $masterArray[] = $allConcededTileData;
                
                    $allShotsTileData[] = "Shots";
                    $allShotsTileData[] = min($allShots);
                    $allShotsTileData[] = max($allShots);
                    $allShotsTileData[] = findMinValueAndReturnTeam($allShots ,$allSeasonClubNames);
                    $allShotsTileData[] = findMaxValueAndReturnTeam($allShots ,$allSeasonClubNames);
                    $masterArray[] = $allShotsTileData;
                
                    $allShotsOTTileData[] = "Shots on Target";
                    $allShotsOTTileData[] = min($allShotsOT);
                    $allShotsOTTileData[] = max($allShotsOT);
                    $allShotsOTTileData[] = findMinValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);
                    $allShotsOTTileData[] = findMaxValueAndReturnTeam($allShotsOT ,$allSeasonClubNames);
                    $masterArray[] = $allShotsOTTileData;
                
                    $allCornersTileData[] = "Corners";
                    $allCornersTileData[] = min($allCorners);
                    $allCornersTileData[] = max($allCorners);
                    $allCornersTileData[] = findMinValueAndReturnTeam($allCorners ,$allSeasonClubNames);
                    $allCornersTileData[] = findMaxValueAndReturnTeam($allCorners ,$allSeasonClubNames);
                    $masterArray[] = $allCornersTileData;
                
                    $allFoulsTileData[] = "Fouls";
                    $allFoulsTileData[] = min($allFouls);
                    $allFoulsTileData[] = max($allFouls);
                    $allFoulsTileData[] = findMinValueAndReturnTeam($allFouls ,$allSeasonClubNames);
                    $allFoulsTileData[] = findMaxValueAndReturnTeam($allFouls ,$allSeasonClubNames);
                    $masterArray[] = $allFoulsTileData;
                
                    $allYellowCardsTileData[] = "Yellow Cards";
                    $allYellowCardsTileData[] = min($allYellowCards);
                    $allYellowCardsTileData[] = max($allYellowCards);
                    $allYellowCardsTileData[] = findMinValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
                    $allYellowCardsTileData[] = findMaxValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
                    $masterArray[] = $allYellowCardsTileData;
                
                    $allRedCardsTileData[] = "Red Cards";
                    $allRedCardsTileData[] = min($allRedCards);
                    $allRedCardsTileData[] = max($allRedCards);
                    $allRedCardsTileData[] = findMinValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
                    $allRedCardsTileData[] = findMaxValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
                    $masterArray[] = $allRedCardsTileData;

                    foreach ($masterArray as $tileData) {
                        // tile name, lowest value, highest value, lowest team, highest team
                        $finalTitle = $tileData[0];
                        $lowStat = $tileData[1];
                        $highStat = $tileData[2];
                        $lowTeamName = $tileData[3];
                        $highTeamName = $tileData[4];
                    
                        echo "
                            <div class='tile is-12 pt-5'>
                                <p>{$finalTitle}</p>
                            </div>
                            <div class='tile is-12 is-parent'>
                                <div class='my_inline_divs tile is-child box level'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$lowTeamName}</p>
                                    </div>
                                    <div class='level-right'>
                                        <div>
                                            <i class='material-icons redicon'>keyboard_arrow_down</i>
                                            <p class='subtitle'>{$lowStat}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class='my_inline_divs tile is-child box level'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$highTeamName}</p>
                                    </div>
                                    <div class='level-right'>
                                        <div>
                                            <i class='material-icons greenicon'>keyboard_arrow_up</i>
                                            <p class='subtitle'>{$highStat}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                ?>
            </div>
        </section>
    </div>
    
    <?php include("part_site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>