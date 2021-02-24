<?php
    $seasonAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/list?all_seasons_list";
    require("api_auth.php");
    $seasonAPIdata = file_get_contents($seasonAPIpath, false, $context);
    $seasonList = json_decode($seasonAPIdata, true);

    if (isset($_GET['season_pref'])) {
        $seasonSelected = $_GET['season_pref'];
    } else {
        $seasonSelected = null;
    }
    
    foreach($seasonList as $singleSeason) {
        if ($seasonSelected == $singleSeason['season']) {
            echo "<option value='{$singleSeason['season']}' selected='selected'>{$singleSeason['season']}</option>";
        } else {
            echo "<option value='{$singleSeason['season']}'>{$singleSeason['season']}</option>";
        }
    }
?>