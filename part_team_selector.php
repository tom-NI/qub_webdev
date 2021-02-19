<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=current_season_clubs";
    $teamAPIdata = file_get_contents($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);

    if (isset($_GET['ht_selector'])) {
        $HTSelected = $_GET['ht_selector'];

        echo "<option value='default'>Select Team</option>";
        foreach($teamList as $singleTeam) {
            if ($HTSelected != null && $HTSelected == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            }  else {
                echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
            }
        }
    } elseif (isset($_GET['at_selector'])) {
        $ATSelected = $_GET['at_selector'];

        echo "<option value='default'>Select Team</option>";
        foreach($teamList as $singleTeamAT) {
            if ($ATSelected != null && $ATSelected == $singleTeamAT['clubname']) { 
                echo "<option value='{$singleTeamAT['clubname']}' selected='selected'>{$singleTeamAT['clubname']}</option>";
            } else {
                echo "<option value='{$singleTeamAT['clubname']}'>{$singleTeamAT['clubname']}</option>";
            }
        }
    } else {
        echo "<option value='default'>Select Team</option>";
        foreach($teamList as $singleTeamHome) {
            echo "<option value='{$singleTeamHome['clubname']}'>{$singleTeamHome['clubname']}</option>";
        }
    }    
?>