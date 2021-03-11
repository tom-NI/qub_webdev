<?php
    $seasonAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/seasons?all_seasons_list";
    require("../logic_files/allfunctions.php");
    $seasonAPIdata = postDevKeyInHeader($seasonAPIpath);
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