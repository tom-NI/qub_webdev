<?php
    // control variable for pagination numbers with the recent matches list
    $loadingRecentResults = false;
    
    // select the main page summary data
    // either filtering, searching, or loading recent results
    if (isset($_GET['userfilter'])) {
        $loadingRecentResults = false;

        // if the user checked the filter panel items
        $rootURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?filter";
        
        // empty string to add on all dynamic user queries for API request
        $urlPathAddons = "";

        // club select (labelled as home team)
        if (isset($_GET['ht_selector']) && $_GET['ht_selector'] != "" 
                && $_GET['ht_selector'] != "Select Team") {
            $clubValue = addUnderScores(htmlentities(trim($_GET['ht_selector'])));
            $urlPathAddons .= "&club={$clubValue}";
        }

        // opposition team (away team)
        if (isset($_GET['at_selector']) && $_GET['at_selector'] != ""
                && $_GET['at_selector'] != "Select Team") {
            $oppositionValue = addUnderScores(htmlentities(trim($_GET['at_selector'])));
            $urlPathAddons .= "&opposition_team={$oppositionValue}";
        }

        if (isset($_GET['season_pref']) && $_GET['season_pref'] != "" 
                && $_GET['season_pref'] != "none") {
            $seasonValue = htmlentities(trim($_GET['season_pref']));
            $urlPathAddons .= "&season={$seasonValue}";
        }

        if (isset($_GET['ht_result']) && $_GET['ht_result'] != "") {
            $htResultValue = (int) htmlentities(trim($_GET['ht_result']));
            if (is_numeric($htResultValue) && $htResultValue >= 0) {
                $urlPathAddons .= "&htresult={$htResultValue}";
            }
        }
        if (isset($_GET['at_result']) && $_GET['at_result'] != "") {
            $atResultValue = (int) htmlentities(trim($_GET['at_result']));
            if (is_numeric($atResultValue) && $atResultValue >= 0) {
                $urlPathAddons .= "&atresult={$atResultValue}";
            }
        }

        if (isset($_GET['user_margin']) && $_GET['user_margin'] != "") {
            $marginValue = (int) htmlentities(trim($_GET['user_margin']));
            if (is_numeric($marginValue) && $marginValue > 0) {
                $urlPathAddons .= "&margin={$marginValue}";
            }
        }

        if (isset($_GET['filter_month_selector']) && $_GET['filter_month_selector'] != "" 
                && $_GET['filter_month_selector'] != "none") {
            $monthValue = htmlentities(trim($_GET['filter_month_selector']));
            if ($monthValue >= 01 && $monthValue <= 12) {
                $urlPathAddons .= "&month={$monthValue}";
            }
        }

        if (isset($_GET['day_selector']) && $_GET['day_selector'] != "" 
                && $_GET['day_selector'] != "none") {
            $dayValue = htmlentities(trim($_GET['day_selector']));
            if ($dayValue >= 1 && $dayValue <= 7) {
                $urlPathAddons .= "&day={$dayValue}";
            }
        }

        if (isset($_GET['referee_selector']) && $_GET['referee_selector'] != "" 
                && $_GET['referee_selector'] != "Select Referee") {
            $refereeValue = addUnderScores(htmlentities(trim($_GET['referee_selector'])));
            $urlPathAddons .= "&referee={$refereeValue}";
        }

        if (strlen($urlPathAddons) > 0) {
            $finalDataURL = "{$rootURL}{$urlPathAddons}{$numResultsReturnedQuery}";
        } else {
            $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?season=2020-2021{$numResultsReturnedQuery}";
        }
    } elseif (isset($_GET['ht_selector'])) {
        // if the user entered something in the club search bar on the homepage!
        $loadingRecentResults = false;
        $userSearchItem = addUnderScores(htmlentities(trim($_GET['ht_selector'])));
        $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?usersearch={$userSearchItem}{$numResultsReturnedQuery}";
    } else {
        // otherwise just load the last ten premier league games
        $currentSeason = getCurrentSeason();
        $loadingRecentResults = true;
        $finalDataURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/match_summaries?season={$currentSeason}{$numResultsReturnedQuery}";
    }
?>