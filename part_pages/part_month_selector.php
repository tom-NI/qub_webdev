<?php
    $monthValuesToMatchDB = array('none', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
    $monthNames = array('Month', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

    if (isset($_GET['filter_month_selector'])) {
        $monthNum = htmlentities(trim($_GET['filter_month_selector']));
    }
    
    for ($i = 0; $i < count($monthValuesToMatchDB); $i++) {
        if (isset($monthNum) && $monthNum == $monthValuesToMatchDB[$i]) {
            echo "<option value='{$monthValuesToMatchDB[$i]}' selected >{$monthNames[$i]}</option>";
        } else {
            echo "<option value='{$monthValuesToMatchDB[$i]}'>{$monthNames[$i]}</option>";
        }
    }
?>