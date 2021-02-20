<?php
    $refereeAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/?list=ref_list";
    $refereeAPIdata = file_get_contents($refereeAPIpath);
    $refereeList = json_decode($refereeAPIdata, true);
    
    echo "<option value='default'>Select Referee</option>";
    foreach($refereeList as $singleRef) {
        echo "<option value='{$singleRef['refereename']}'>{$singleRef['refereename']}</option>";
    }
?>