<?php
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs?all_clubs";
    $teamAPIdata = postDevKeyInHeader($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);
    
    echo "<option value=''>Select Team</option>";
    foreach($teamList as $singleTeamHome) {
        echo "<option value='{$singleTeamHome['club']}'>{$singleTeamHome['club']}</option>";
    }
?>