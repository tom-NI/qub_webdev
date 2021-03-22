<?php
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs?all_clubs";
    $teamAPIdata = postDevKeyInHeader($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);

    echo "<option value='Select Team'>Select Team</option>";
    if (!isset($htSelectorIsSet)) {
        foreach($teamList as $singleTeam) {
            if (isset($_GET['ht_selector']) && $_GET['ht_selector'] == $singleTeam['club']) {
                echo "<option value='{$singleTeam['club']}' selected='selected'>{$singleTeam['club']}</option>";
            } else {
                echo "<option value='{$singleTeam['club']}'>{$singleTeam['club']}</option>";
            }
        }
    } else {
        foreach($teamList as $singleTeam) {
            if (isset($_GET['at_selector']) && $_GET['at_selector'] == $singleTeam['club']) {
                echo "<option value='{$singleTeam['club']}' selected='selected'>{$singleTeam['club']}</option>";
            } else {
                echo "<option value='{$singleTeam['club']}'>{$singleTeam['club']}</option>";
            }
        }
    }
?>