<?php
    // load all the data from the db and populate it into the relevant boxes for the form, then echo the form out!
    $zero = 0;

    $sectionTitles = array(
        "Half Time Goals:",
        "Full Time Goals:",
        "Total Shots:",
        "Shots on Target:",
        "Corners:",
        "Total Fouls:",
        "Yellow Cards:",
        "Red Cards:"
    );

    $maxValues = array(
        50,
        50,
        50,
        50,
        200,
        100,
        22,
        5
    );
    $homeNameIDs = array(
        "ht_ht_goals",
        "ht_ft_goals",
        "ht_total_shots",
        "ht_shots_on_target",
        "ht_corners",
        "ht_total_fouls",
        "ht_yellow_cards",
        "ht_red_cards",
    );

    $awayNameIDs = array(
        "at_ht_goals",
        "at_ft_goals",
        "at_total_shots",
        "at_shots_on_target",
        "at_corners",
        "at_total_fouls",
        "at_yellow_cards",
        "at_red_cards",
    );

    $homeValues = array(
        $hometeamtotalgoals,
        $hometeamhalftimegoals,
        $hometeamshots,
        $hometeamshotsontarget,
        $hometeamcorners,
        $hometeamfouls,
        $hometeamyellowcards,
        $hometeamredcards
    );

    $awayValues = array(
        $awayteamtotalgoals,
        $awayteamhalftimegoals,
        $awayteamshots,
        $awayteamshotsontarget,
        $awayteamcorners,
        $awayteamfouls,
        $awayteamyellowcards,
        $awayteamredcards
    );

    for ($i = 0; $i < 8; $i++) {
        echo "<div class='field'>
            <p>{$sectionTitles[$i]}</p>
            <div class='my_inline_divs m-1 p-1'>
                <input required class='my_small_num_entry input is-success' type='number' placeholder='{$zero}'
                    min='{$zero}' max='{$maxValues[$i]}' value='{$homeValues[$i]}' id='{$homeNameIDs[$i]}' name='{$homeNameIDs[$i]}'>
            </div>
            <div class='my_inline_divs m-1 p-1'>
                <input class='my_small_num_entry input is-danger' type='number' required placeholder='{$zero}'
                    min='{$zero}' max='{$maxValues[$i]}' value='{$awayValues[$i]}' id='{$awayNameIDs[$i]}' name='{$awayNameIDs[$i]}'>
            </div>
        </div>";
    }
?>