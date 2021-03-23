<?php
    $refereeAPIpath = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/referees?ref_list";
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    $refereeAPIdata = postDevKeyInHeader($refereeAPIpath);
    $refereeList = json_decode($refereeAPIdata, true);
    
    // if this isnt an edit page, make the default to be "select ref"
    if (!isset($existingRefereeNameToEdit)) {
        echo "<option value=''>Select Referee</option>";
    }

    // modify the output based on the page type (edit or add new)
    foreach($refereeList as $singleRef) {
        if (isset($existingRefereeNameToEdit) && $existingRefereeNameToEdit == $singleRef['referee_name']) {
            echo "<option value='{$singleRef['referee_name']}' selected='selected'>{$singleRef['referee_name']}</option>";
        } elseif(isset($_GET['referee_selector']) && $_GET['referee_selector'] == $singleRef['referee_name']) {
            echo "<option value='{$singleRef['referee_name']}' selected='selected'>{$singleRef['referee_name']}</option>";
        } else {
            echo "<option value='{$singleRef['referee_name']}'>{$singleRef['referee_name']}</option>";
        }
    }
?>