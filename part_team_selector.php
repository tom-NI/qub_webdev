<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=current_season_clubs";
    $teamAPIdata = file_get_contents($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);

    if (isset($_GET['ht_selector'])) {
        $HTSelected = $_GET['ht_selector'];
    } else {
        $HTSelected = null;
    }
    if (isset($_GET['at_selector'])) {
        $ATSelected = $_GET['at_selector'];
    } else {
        $ATSelected = null;
    }
    
    echo "<option value='default'>Select Team</option>";
    foreach($teamList as $singleTeam) {
        if (isset($_GET['ht_selector'])) {
            if ($HTSelected == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            } else {
                echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
            } 
        } elseif (isset($_GET['at_selector'])) { 
            if($ATSelected == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            } else {
                echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
            }
        } else {
            echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
        }
    }
?>