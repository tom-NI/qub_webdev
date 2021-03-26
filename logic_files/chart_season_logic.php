<?php
    // set the requested stat from the user, else default to goals
    if (isset($_GET['stattile_statistic'])) {
        $statToAnalyze = htmlentities(trim($_GET['stattile_statistic']));
    } else {
        $statToAnalyze = "Goals";
    }

    // get the requested season data from the user, else default to the current season and retrieve it!
    if (isset($_GET['season_pref'])) {
        $season = htmlentities(trim($_GET['season_pref']));
    } else {
        $season = getCurrentSeason();
    }
    $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fullseason={$season}";
    $seasonAPIdata = postDevKeyInHeader($seasonInfoURL);
    $seasonGameList = json_decode($seasonAPIdata, true);

    if (count($seasonGameList) > 0) {
        $noMatchesToAnalyse = false;
        $goalsConcededStatisticRequested = false;
    
        // get the JSON statistic keys based only on the info requested by the user
        switch ($statToAnalyze) {
            case "Goals":
                $homeStatKey = 'home_team_total_goals';
                $awayStatKey = 'away_team_total_goals';
                break;
            case "Goals Conceded":
                $goalsConcededStatisticRequested = true;
                $homeStatKey = 'away_team_total_goals';
                $awayStatKey = 'home_team_total_goals';
                break;
            case "Shots":
                $homeStatKey = 'home_team_shots';
                $awayStatKey = 'away_team_shots';
                break;
            case "Shots On Target":
                $homeStatKey = 'home_team_shots_on_target';
                $awayStatKey = 'away_team_shots_on_target';
                break;
            case "Corners":
                $homeStatKey = 'home_team_corners';
                $awayStatKey = 'away_team_corners';
                break;
            case "Fouls":
                $homeStatKey = 'home_team_fouls';
                $awayStatKey = 'away_team_fouls';
                break;
            case "Yellow Cards":
                $homeStatKey = 'home_team_yellow_cards';
                $awayStatKey = 'away_team_yellow_cards';
                break;
            case "Red Cards":
                $homeStatKey = 'home_team_red_cards';
                $awayStatKey = 'away_team_red_cards';
                break;
            default :
                $homeStatKey = 'home_team_total_goals';
                $awayStatKey = 'away_team_total_goals';
                break;
        }
    
        // array to hold the full seasons stats (assoc array, clubname is the key)
        $statisticArray = array();
        
        foreach($seasonGameList as $match) {
            $homeTeam = $match['home_team'];
            $awayTeam = $match['away_team'];
    
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
    } else {
        $noMatchesToAnalyse = true;
    }
?>