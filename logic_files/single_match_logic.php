<?php
    // logic for a single match - used on single match page only.
    if (isset($_GET['num'])) {
        $postedMatchID = $_GET['num'];
        $singleMatchURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?onematch={$postedMatchID}";
        $singleMatchData = postDevKeyInHeader($singleMatchURL);
        $singleMatchList = json_decode($singleMatchData, true);

        foreach($singleMatchList as $singleMatchInfo) {
            $matchdate = $singleMatchInfo['match_date'];
            $kickofftime = $singleMatchInfo['kick_off_time'];
            $refereename = $singleMatchInfo['referee_name'];
            $hometeam = $singleMatchInfo['home_team'];
            $awayteam = $singleMatchInfo['away_team'];
            $hometeamlogoURL = $singleMatchInfo['home_team_logo_URL'];
            $awayteamlogoURL = $singleMatchInfo['away_team_logo_URL'];

            $hometeamtotalgoals = $singleMatchInfo['home_team_total_goals'];
            $hometeamhalftimegoals = $singleMatchInfo['home_team_half_time_goals'];
            $hometeamshots = $singleMatchInfo['home_team_shots'];
            $hometeamshotsontarget = $singleMatchInfo['home_team_shots_on_target'];
            $hometeamcorners = $singleMatchInfo['home_team_corners'];
            $hometeamfouls = $singleMatchInfo['home_team_fouls'];
            $hometeamyellowcards = $singleMatchInfo['home_team_yellow_cards'];
            $hometeamredcards = $singleMatchInfo['home_team_red_cards'];

            $awayteamtotalgoals = $singleMatchInfo['away_team_total_goals'];
            $awayteamhalftimegoals = $singleMatchInfo['away_team_half_time_goals'];
            $awayteamshots = $singleMatchInfo['away_team_shots'];
            $awayteamshotsontarget = $singleMatchInfo['away_team_shots_on_target'];
            $awayteamcorners = $singleMatchInfo['away_team_corners'];
            $awayteamfouls = $singleMatchInfo['away_team_fouls'];
            $awayteamyellowcards = $singleMatchInfo['away_team_yellow_cards'];
            $awayteamredcards = $singleMatchInfo['away_team_red_cards'];
        }

        $homeTeamForLinks = addUnderScores(trim($hometeam));
        $awayTeamForLinks = addUnderScores(trim($awayteam));

        $htPercentShotsOT = calculatePercentage($hometeamshotsontarget, $hometeamshots);
        $atPercentShotsOT = calculatePercentage($awayteamshotsontarget, $awayteamshots);

        $htStatsForGraph = array($hometeamhalftimegoals,$hometeamshots,$hometeamshotsontarget,$htPercentShotsOT,$hometeamcorners,$hometeamfouls,$hometeamyellowcards,$hometeamredcards);
        $atStatsForGraph = array($awayteamhalftimegoals,$awayteamshots,$awayteamshotsontarget,$atPercentShotsOT,$awayteamcorners,$awayteamfouls,$awayteamyellowcards,$awayteamredcards);

        $presentableMatchDate = parseDateLongFormat($matchdate);
        $presentShortDate = parseDateShortFormat($matchdate);
    }

    // now GET the previous 5 fixtures of this match for the JS graph!
    $homeTeamSearched = addUnderScores($hometeam);
    $awayTeamSearched = addUnderScores($awayteam);
    $pastFixturesURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fixture={$homeTeamSearched}~{$awayTeamSearched}&pre_date={$matchdate}&count=5";
    $pastFixturesData = postDevKeyInHeader($pastFixturesURL);
    $pastFixturesList = json_decode($pastFixturesData, true);

    // only build the recent stats if there are stats to show!
    if (count($pastFixturesList) > 0) {
        // var to count the previous number of matches
        $previousMatchCount = 0;

        // control var for the UI
        $noPreviousMatchesToShow = false;

        // decide the stat from user input, or if not set, defaults to goals
        if (isset($_POST['change_stat_btn'])) {
            $statToAnalyze = htmlentities(trim($_POST['analyzed_statistic']));
        } else {
            $statToAnalyze = "Goals";
        }

        // build the subarray for titles etc, add to the main chart data array
        $mainStatGraphData = array();
        $headersArray = array();
        $headersArray[] = $statToAnalyze;
        $headersArray[] = $hometeam;
        $headersArray[] = $awayteam;
        $mainStatGraphData[0] = $headersArray;

        $percentNeedsCalculated = false;
        
        // get the JSON statistic keys based only on the info requested
        switch ($statToAnalyze) {
            case "Goals":
                $homeStatKey = 'home_team_total_goals';
                $awayStatKey = 'away_team_total_goals';
                break;
            case "Half Time Goals":
                $homeStatKey = 'home_team_half_time_goals';
                $awayStatKey = 'away_team_half_time_goals';
                break;
            case "Shots":
                $homeStatKey = 'home_team_shots';
                $awayStatKey = 'away_team_shots';
                break;
            case "Shots On Target":
                $homeStatKey = 'home_team_shots_on_target';
                $awayStatKey = 'away_team_shots_on_target';
                break;
            case "% Shots On Target":
                $percentNeedsCalculated = true;          
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

        // build a final array from the keys decided above to pass to JS chart
        foreach($pastFixturesList as $fixture) {
            $previousMatchCount++;
            $singleMatchData = array();
            $dbDate = $fixture['match_date'];
            $singleMatchData[] = parseDateShortFormat($dbDate);
            if ($percentNeedsCalculated) {
                $singleMatchData[] = calculatePercentageAsInt($fixture['home_team_shots_on_target'], $fixture['home_team_shots']);
                $singleMatchData[] = calculatePercentageAsInt($fixture['away_team_shots_on_target'], $fixture['away_team_shots']);
            } else {
                $singleMatchData[] = (int) $fixture[$homeStatKey];
                $singleMatchData[] = (int) $fixture[$awayStatKey];
            }
            $mainStatGraphData[] = $singleMatchData;
        }
    } else {
        $noPreviousMatchesToShow = true;
    }
?>
