<?php
    $seasonAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=all_seasons_list";
    $seasonAPIdata = file_get_contents($seasonAPIpath);
    $seasonList = json_decode($seasonAPIdata, true);
    
    foreach($seasonList as $singleSeason) {
        echo "<option value='{$singleSeason['season']}'>{$singleSeason['season']}</option>";
    }
?>