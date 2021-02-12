<?php
    $teamAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=current_season_clubs";
    $teamAPIdata = file_get_contents($teamAPIpath);
    $teamList = json_decode($teamAPIdata, true);
    
    echo "<option value='default'>Select Team</option>";
    foreach($teamList as $singleTeam) {
        echo "<option value='{$singleTeam['clubname']}'>{$singleTeam['clubname']}</option>";
    }
    
?>