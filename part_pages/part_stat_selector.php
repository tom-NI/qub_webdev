<?php
    $statValues = array();
    array_push($statValues, "Goals", "Half Time Goals", "Shots", "Shots On Target", "% Shots On Target", "Corners", "Fouls", "Yellow Cards", "Red Cards");

    if (isset($_POST['analyzed_statistic'])) {
        $statSelected = htmlentities(trim($_POST['analyzed_statistic']));
    } else {
        $statSelected = null;
    }

    foreach($statValues as $stat) {
        if ($statSelected === $stat) {
            echo "<option value='{$stat}' selected='selected'>{$stat}</option>";
        } else {
            echo "<option value='{$stat}'>{$stat}</option>";
        }
    }
?>