<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/epl_api_v1/list?current_season_clubs";
    require("api_auth.php");
    $teamAPIdata = file_get_contents($teamAPIpath, false, $context);
    $teamList = json_decode($teamAPIdata, true);

    if (isset($_GET['ht_selector']) && isset($_GET['at_selector'])) {
        $HTSelected = $_GET['ht_selector'];
        $ATSelected = $_GET['at_selector'];

        // if on an edit page, dont show the default "select team" option
        if (!isset($homeTeamToEdit)) {
            echo "<option value='default'>Select Team</option>";
        }
        
        foreach($teamList as $singleTeam) {
            // for edit pages, set the selector to default to the existing team name
            if (isset($homeTeamToEdit) && $homeTeamToEdit == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            }
            if (isset($awayTeamToEdit) && $awayTeamToEdit == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            }

            if ($HTSelected != null && $HTSelected == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            } elseif ($ATSelected != null && $ATSelected == $singleTeam['clubname']) {
                echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
            } else {
                echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
            }
        }
    } else {
        echo "<option value='default'>Select Team</option>";
        foreach($teamList as $singleTeamHome) {
            echo "<option value='{$singleTeamHome['clubname']}'>{$singleTeamHome['clubname']}</option>";
        }
    }    
?>