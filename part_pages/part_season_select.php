<?php
    $seasonAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/seasons?all_seasons_list";
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    $seasonAPIdata = postDevKeyInHeader($seasonAPIpath);
    $seasonList = json_decode($seasonAPIdata, true);

    $currentSeason = getCurrentSeason();

    // change the <select> state based on the page and user selection
    if ($findMatchPage && !isset($_GET['season_pref'])) {
        foreach($seasonList as $singleSeason) {
            echo "<option value='{$singleSeason['season']}'>{$singleSeason['season']}</option>";
        }
    } elseif (!isset($_GET['season_pref'])) {
        $seasonSelected = null;
        // set to the current season if the user hasnt selected a season preference
        foreach($seasonList as $singleSeason) {
            if ($singleSeason['season'] === $currentSeason) {
                echo "<option value='{$singleSeason['season']}' selected='selected'>{$singleSeason['season']}</option>";
            } else {
                echo "<option value='{$singleSeason['season']}'>{$singleSeason['season']}</option>";
            }
        }
    } elseif (isset($_GET['season_pref'])) {
        $seasonSelected = $_GET['season_pref'];
        // get the users preference, and if it matches a season in the DB, set it to that
        foreach($seasonList as $singleSeason) {
            if ($seasonSelected == $singleSeason['season']) {
                echo "<option value='{$singleSeason['season']}' selected='selected'>{$singleSeason['season']}</option>";
            } else {
                echo "<option value='{$singleSeason['season']}'>{$singleSeason['season']}</option>";
            }
        }
    }
?>