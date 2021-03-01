<?php
    $refereeAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/list?ref_list";
    require("api_auth.php");
    $refereeAPIdata = file_get_contents($refereeAPIpath, false, $context);
    $refereeList = json_decode($refereeAPIdata, true);
    
    // if this isnt an edit page, make the default to be "select ref"
    if (!isset($existingRefereeNameToEdit)) {
        echo "<option value=''>Select Referee</option>";
    }

    // modify the output based on the page type (edit or add new)
    foreach($refereeList as $singleRef) {
        if (isset($existingRefereeNameToEdit) && $existingRefereeNameToEdit == $singleRef['refname']) {
            echo "<option value='{$singleRef['refname']}' selected='selected'>{$singleRef['refname']}</option>";
        } else {
            echo "<option value='{$singleRef['refname']}'>{$singleRef['refname']}</option>";
        }
    }
?>