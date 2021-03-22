<?php
    $statValues = array();
    array_push($statValues, "Goals", "Goals Conceded", "Shots", "Shots On Target", "Corners", "Fouls", "Yellow Cards", "Red Cards");

    if (isset($_GET['stattile_statistic'])) {
        $statSelected = htmlentities(trim($_GET['stattile_statistic']));
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