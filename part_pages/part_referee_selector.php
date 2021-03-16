<?php
    $refereeAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/referees?ref_list";
    include_once("logic_files/allfunctions.php");
    $refereeAPIdata = postDevKeyInHeader($refereeAPIpath);
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