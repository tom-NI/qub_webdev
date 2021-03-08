<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs?all_clubs";
    require("api_auth.php");
    $teamAPIdata = file_get_contents($teamAPIpath, false, $context);
    $teamList = json_decode($teamAPIdata, true);
    
    echo "<option value=''>Select Team</option>";
    foreach($teamList as $singleTeamHome) {
        echo "<option value='{$singleTeamHome['club']}'>{$singleTeamHome['club']}</option>";
    }
?>