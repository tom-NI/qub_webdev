<?php
    session_start();
    include_once("logic_files/allfunctions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <title>EPL Match Statistic Finder</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">

    <!-- Full nav bar -->
    <?php include("part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">The home of English Premier League Match Statistics</h1>
                <p class="subtitle is-5 mt-2">Search below to get started</p>
                <?php
                    if (isset($_SESSION['sessiontype']) && strlen($_SESSION['sessiontype']) > 0) {
                        echo "<p>User ID = {$_SESSION['userid']}</p>";
                        echo "<p>User Name = {$_SESSION['username']}</p>";
                    } else {
                        echo "<p>Session not set</p>";
                    }
                ?>
            </div>
        </div>
    </section>

    <!-- home page split into two -->
    <div class="columns is-desktop master_site_width">
        <section class="section column is-three-fifths-desktop mx-2">
            <div class="container is-centered">
                <!-- search bar -->
                <div>
                    <form action="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_advanced_search.php" method="GET">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input is-rounded" type="text" placeholder="Search for clubs to view results"
                                    name="search" id="main_page_search">
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
                    <img src="https://i.imgur.com/Ok815ec.jpg" alt="" class="box">
                    <caption>
                        Manchester United and Liverpool are neck and neck this season in the title race
                    </caption>
                </figure>
            </div>
            <h3 class="title is-4 m-3 mt-6">Most recent Premier League results;</h3>
            <p class="subtitle is-6 m-3">Click any result to view match details</p>

            <!-- most recent premier league match results -->
            <?php
                $finalURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?count=8";
                require("part_pages/part_print_summaries.php");
            ?>
        </section>

        <!-- stat tiles section -->
        <section class="section column container my_grey_highlight_para mx-5">
            <div class="container">
                <h3 class="title is-4 mb-5">StatTiles</h3>
            </div>
            <div class="container">
                <form method="GET" action="index.php" class="level mb-3">
                    <div class="p-2 level-item">
                        <label for="season_select"><b>Select Season :</b></label>
                    </div>
                    <div class="select control is-expanded is-link level-item">
                        <select name="season_pref" id="season_select">
                            <?php
                                require("part_pages/part_season_select.php");
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
                        $season = htmlentities(trim($_GET['season_pref']));
                        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$season}";
                    } else {
                        $currentMaxSeasonInDB = getCurrentSeason();
                        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$currentMaxSeasonInDB}";
                    }
                    $seasonAPIdata = postDevKeyInHeader($seasonInfoURL);
                    $seasonGameList = json_decode($seasonAPIdata, true);
                
                    // add all the club names into an array of current season teams
                    $allSeasonClubNames = array();
                    $allSeasonGamesPlayedByClub = array();
                
                    // store every metric to be measured in an array
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
                
                        // check if the team is in the allSeasonClubNames array, if not add.
                        // return club index to use later in the code
                        if (array_search($homeTeamName, $allSeasonClubNames) != false) {
                            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
                            $allSeasonGamesPlayedByClub[$homeTeamIndex] += 1;
                        } else {
                            // otherwise add the item to the array, and then return its index
                            array_push($allSeasonClubNames, $homeTeamName);
                            array_push($allSeasonGamesPlayedByClub, 1);
                            $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
                        }
                        if (array_search($awayTeamName, $allSeasonClubNames) != false) {
                            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
                            $allSeasonGamesPlayedByClub[$awayTeamIndex] += 1;
                        } else {
                            array_push($allSeasonClubNames, $awayTeamName);
                            array_push($allSeasonGamesPlayedByClub, 1);
                            $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
                        }
                        
                        $allSeasonGamesPlayedByClub[$awayTeamIndex] += 1;

                        // check if the teams index exists in the array and add on data if so
                        // else, push the data onto the end of the array, array is updated for each func call
                        $allGoals = searchAndAddToArray($singleMatch["hometeamtotalgoals"], $allGoals, $homeTeamIndex);
                        $allConceded = searchAndAddToArray($singleMatch["hometeamtotalgoals"], $allConceded, $awayTeamIndex);
                        $allShots = searchAndAddToArray($singleMatch["hometeamshots"], $allShots, $homeTeamIndex);
                        $allShotsOT = searchAndAddToArray($singleMatch["hometeamshotsontarget"], $allShotsOT, $homeTeamIndex);
                        $allCorners = searchAndAddToArray($singleMatch["hometeamcorners"], $allCorners, $homeTeamIndex);
                        $allFouls = searchAndAddToArray($singleMatch["hometeamfouls"], $allFouls, $homeTeamIndex);
                        $allYellowCards = searchAndAddToArray($singleMatch["hometeamyellowcards"], $allYellowCards, $homeTeamIndex);
                        $allRedCards = searchAndAddToArray($singleMatch["hometeamredcards"], $allRedCards, $homeTeamIndex);
                        
                        $allGoals = searchAndAddToArray($singleMatch["awayteamtotalgoals"], $allGoals, $awayTeamIndex);
                        $allConceded = searchAndAddToArray($singleMatch["awayteamtotalgoals"], $allConceded, $homeTeamIndex);
                        $allShots = searchAndAddToArray($singleMatch["awayteamshots"], $allShots, $awayTeamIndex);
                        $allShotsOT = searchAndAddToArray($singleMatch["awayteamshotsontarget"], $allShotsOT, $awayTeamIndex);
                        $allCorners = searchAndAddToArray($singleMatch["awayteamcorners"], $allCorners, $awayTeamIndex);
                        $allFouls = searchAndAddToArray($singleMatch["awayteamfouls"], $allFouls, $awayTeamIndex);
                        $allYellowCards = searchAndAddToArray($singleMatch["awayteamyellowcards"], $allYellowCards, $awayTeamIndex);
                        $allRedCards = searchAndAddToArray($singleMatch["awayteamredcards"], $allRedCards, $awayTeamIndex);
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
                    $allGoalsTileData[] = min($allGoals);
                    $allGoalsTileData[] = max($allGoals);
                    $allGoalsTileData[] = findMinValueAndReturnTeam($allGoals ,$allSeasonClubNames);
                    $allGoalsTileData[] = findMaxValueAndReturnTeam($allGoals ,$allSeasonClubNames);
                    $masterArray[] = $allGoalsTileData;
                
                    $allConcededTileData[] = "Goals Conceded";
                    $allConcededTileData[] = max($allConceded);
                    $allConcededTileData[] = min($allConceded);
                    $allConcededTileData[] = findMaxValueAndReturnTeam($allConceded ,$allSeasonClubNames);
                    $allConcededTileData[] = findMinValueAndReturnTeam($allConceded ,$allSeasonClubNames);
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
                    $allFoulsTileData[] = max($allFouls);
                    $allFoulsTileData[] = min($allFouls);
                    $allFoulsTileData[] = findMaxValueAndReturnTeam($allFouls ,$allSeasonClubNames);
                    $allFoulsTileData[] = findMinValueAndReturnTeam($allFouls ,$allSeasonClubNames);
                    $masterArray[] = $allFoulsTileData;
                
                    $allYellowCardsTileData[] = "Yellow Cards";
                    $allYellowCardsTileData[] = max($allYellowCards);
                    $allYellowCardsTileData[] = min($allYellowCards);
                    $allYellowCardsTileData[] = findMaxValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
                    $allYellowCardsTileData[] = findMinValueAndReturnTeam($allYellowCards ,$allSeasonClubNames);
                    $masterArray[] = $allYellowCardsTileData;
                
                    $allRedCardsTileData[] = "Red Cards";
                    $allRedCardsTileData[] = max($allRedCards);
                    $allRedCardsTileData[] = min($allRedCards);
                    $allRedCardsTileData[] = findMaxValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
                    $allRedCardsTileData[] = findMinValueAndReturnTeam($allRedCards ,$allSeasonClubNames);
                    $masterArray[] = $allRedCardsTileData;

                    foreach ($masterArray as $tileData) {
                        // tile name, lowest value, highest value, lowest team, highest team
                        $finalTitle = $tileData[0];
                        $lowStat = $tileData[1];
                        $highStat = $tileData[2];
                        $lowTeamName = $tileData[3];
                        $highTeamName = $tileData[4];

                        // calculate the games played for the club in question
                        // then calc ratio per game for display
                        $lowTeamIndex = array_search($lowTeamName, $allSeasonGamesPlayedByClub);
                        $highTeamIndex = array_search($highTeamName, $allSeasonGamesPlayedByClub);
                        $lowTeamGamesPlayed = $allSeasonGamesPlayedByClub[$lowTeamIndex];
                        $highTeamGamesPlayed = $allSeasonGamesPlayedByClub[$highTeamIndex];
                        $lowRatioPG = calculateAverageTwoDP($lowStat, $lowTeamGamesPlayed);
                        $highRatioPG = calculateAverageTwoDP($highStat ,$highTeamGamesPlayed);
                        
                        echo "
                        <div class='tile is-12 pt-5'>
                            <p><b>{$finalTitle}:</b></p>
                        </div>
                        <div class='tile is-12 is-mobile is-parent'>
                            <div class='is-child box tile'>
                                <div class=' level my-2'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$lowTeamName}</p>
                                    </div>
                                    <div class='level-right level-item my-3'>
                                        <div>
                                            <i class='material-icons redicon'>clear</i>
                                            <p class='subtitle'><b>{$lowStat}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class='subtitle is-7'>{$lowRatioPG} per match</p>
                                </div>
                            </div>
                            <div class='is-child box tile'>
                                <div class=' level my-2'>
                                    <div class='level-left level-item my_level_wrap'>
                                        <p class='has-text-left p-1'>{$highTeamName}</p>
                                    </div>
                                    <div class='level-right level-item my-3'>
                                        <div>
                                            <i class='material-icons greenicon'>done</i>
                                            <p class='subtitle'><b>{$highStat}</b></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p class='subtitle is-7'>{$highRatioPG} per match</p>
                                </div>
                            </div>
                        </div>";
                    }
                ?>
            </div>
        </section>
    </div>
    
    <?php include("part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>
</html>