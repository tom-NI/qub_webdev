<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs?current_season_clubs";
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    $teamAPIdata = postDevKeyInHeader($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);

    if (isset($_POST['ht_selector']) && isset($_POST['at_selector'])) {
        // if on an edit page, dont show the default "select team" option
        if (!isset($homeTeamToEdit)) {
            echo "<option value='Select Team'>Select Team</option>";
        }
        
        if (!$htSelectorIsSet) {
            foreach($teamList as $singleTeam) {
                // for edit pages, set the selector to default to the existing team name
                if (!isset($homeTeamToEdit) || (isset($homeTeamToEdit) && $homeTeamToEdit != $singleTeam['clubname'])) {
                    echo "<option value='{$singleTeam['clubname']}' >{$singleTeam['clubname']}</option>";
                } else {
                    echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
                }
            }
        } else {
            foreach($teamList as $singleTeam) {
                // for edit pages, set the selector to default to the existing team name
                if (!isset($awayTeamToEdit) || (isset($awayTeamToEdit) && $awayTeamToEdit != $singleTeam['clubname'])) {
                    echo "<option value='{$singleTeam['clubname']}' >{$singleTeam['clubname']}</option>";
                } else {
                    echo "<option value='{$singleTeam['clubname']}' selected='selected'>{$singleTeam['clubname']}</option>";
                }
            }
        }
    } else {
        echo "<option value=''>Select Team</option>";
        foreach($teamList as $singleTeamHome) {
            echo "<option value='{$singleTeamHome['clubname']}'>{$singleTeamHome['clubname']}</option>";
        }
    }    
?>