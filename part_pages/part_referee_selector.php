<?php
    $refereeAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/epl_api_v1/list?ref_list";
    require("api_auth.php");
    $refereeAPIdata = file_get_contents($refereeAPIpath, false, $context);
    $refereeList = json_decode($refereeAPIdata, true);
    
    echo "<option value='default'>Select Referee</option>";
    foreach($refereeList as $singleRef) {
        echo "<option value='{$singleRef['refereename']}'>{$singleRef['refereename']}</option>";
    }
?>