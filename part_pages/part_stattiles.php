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

    // array that stores the total number of games each team has played
    // (whose index will then match the allSeasonClubNames) 
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

    if (count($seasonGameList) > 0) {
        foreach($seasonGameList as $singleMatch) {
            $homeTeamName = trim($singleMatch["home_team"]);
            $awayTeamName = trim($singleMatch["away_team"]);

            // check if the team is in the allSeasonClubNames array, if not add.
            // return club index to use later in the code
            if (array_search($homeTeamName, $allSeasonClubNames) !== false) {
                $homeTeamIndex = (int) array_search($homeTeamName, $allSeasonClubNames);
                $allSeasonGamesPlayedByClub[$homeTeamIndex] += 1;
            } else {
                // otherwise add the item to the array, and then return its index
                array_push($allSeasonClubNames, $homeTeamName);
                array_push($allSeasonGamesPlayedByClub, 1);
                $homeTeamIndex = array_search($homeTeamName, $allSeasonClubNames);
            }
            if (array_search($awayTeamName, $allSeasonClubNames) !== false) {
                $awayTeamIndex = (int) array_search($awayTeamName, $allSeasonClubNames);
                $allSeasonGamesPlayedByClub[$awayTeamIndex] += 1;
            } else {
                array_push($allSeasonClubNames, $awayTeamName);
                array_push($allSeasonGamesPlayedByClub, 1);
                $awayTeamIndex = array_search($awayTeamName, $allSeasonClubNames);
            }
            
            // check if the teams index exists in the array and add on data if so
            // else, push the data onto the end of the array, array is updated for each func call
            $allGoals = searchAndAddToArray($singleMatch["home_team_total_goals"], $allGoals, $homeTeamIndex);
            $allConceded = searchAndAddToArray($singleMatch["home_team_total_goals"], $allConceded, $awayTeamIndex);
            $allShots = searchAndAddToArray($singleMatch["home_team_shots"], $allShots, $homeTeamIndex);
            $allShotsOT = searchAndAddToArray($singleMatch["home_team_shots_on_target"], $allShotsOT, $homeTeamIndex);
            $allCorners = searchAndAddToArray($singleMatch["home_team_corners"], $allCorners, $homeTeamIndex);
            $allFouls = searchAndAddToArray($singleMatch["home_team_fouls"], $allFouls, $homeTeamIndex);
            $allYellowCards = searchAndAddToArray($singleMatch["home_team_yellow_cards"], $allYellowCards, $homeTeamIndex);
            $allRedCards = searchAndAddToArray($singleMatch["home_team_red_cards"], $allRedCards, $homeTeamIndex);
            
            $allGoals = searchAndAddToArray($singleMatch["away_team_total_goals"], $allGoals, $awayTeamIndex);
            $allConceded = searchAndAddToArray($singleMatch["away_team_total_goals"], $allConceded, $homeTeamIndex);
            $allShots = searchAndAddToArray($singleMatch["away_team_shots"], $allShots, $awayTeamIndex);
            $allShotsOT = searchAndAddToArray($singleMatch["away_team_shots_on_target"], $allShotsOT, $awayTeamIndex);
            $allCorners = searchAndAddToArray($singleMatch["away_team_corners"], $allCorners, $awayTeamIndex);
            $allFouls = searchAndAddToArray($singleMatch["away_team_fouls"], $allFouls, $awayTeamIndex);
            $allYellowCards = searchAndAddToArray($singleMatch["away_team_yellow_cards"], $allYellowCards, $awayTeamIndex);
            $allRedCards = searchAndAddToArray($singleMatch["away_team_red_cards"], $allRedCards, $awayTeamIndex);
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
                <div class='tile is-12 is-parent level is-mobile'>
                    <div class='box tile is-child'>
                        <div class='level my-2'>
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
                    <div class='box tile is-child'>
                        <div class='level my-2'>
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
    } else {
        echo "
        <div class='tile is-12 is-mobile is-parent'>
            <div class='is-child box tile'>
                <div class=' level my-2'>
                    <div class='level-left level-item my_level_wrap'>
                        <p class='has-text-left p-1'>This Season has no data, please select another season</p>
                    </div>
                </div>
            </div>
        </div>";
    }
?>