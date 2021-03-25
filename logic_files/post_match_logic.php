<?php
    $seasonName = getCurrentSeason();
    $matchDate = htmlentities(trim($_POST['match_date']));
    $kickOffTime = htmlentities(trim($_POST['kickoff_time']));
    $kickOffTime = parseTimeForDBEntry($kickOffTime);
    $refereeName = htmlentities(trim($_POST['select_ref']));
    $homeClubName = htmlentities(trim($_POST['ht_selector']));
    $awayClubName = htmlentities(trim($_POST['at_selector']));
    $homeTeamTotalGoals = (int) htmlentities(trim($_POST['ht_ft_goals']));
    $homeTeamHalfTimeGoals = (int) htmlentities(trim($_POST['ht_ht_goals']));
    $homeTeamShots = (int) htmlentities(trim($_POST['ht_total_shots']));
    $homeTeamShotsOnTarget = (int) htmlentities(trim($_POST['ht_shots_on_target']));
    $homeTeamCorners = (int) htmlentities(trim($_POST['ht_corners']));
    $homeTeamFouls = (int) htmlentities(trim($_POST['ht_total_fouls']));
    $homeTeamYellowCards = (int) htmlentities(trim($_POST['ht_yellow_cards']));
    $homeTeamRedCards = (int) htmlentities(trim($_POST['ht_red_cards']));

    $awayTeamTotalGoals = (int) htmlentities(trim($_POST['at_ft_goals']));
    $awayTeamHalfTimeGoals = (int) htmlentities(trim($_POST['at_ht_goals']));
    $awayTeamShots = (int) htmlentities(trim($_POST['at_total_shots']));
    $awayTeamShotsOnTarget = (int) htmlentities(trim($_POST['at_shots_on_target']));
    $awayTeamCorners = (int) htmlentities(trim($_POST['at_corners']));
    $awayTeamFouls = (int) htmlentities(trim($_POST['at_total_fouls']));
    $awayTeamYellowCards = (int) htmlentities(trim($_POST['at_yellow_cards']));
    $awayTeamRedCards = (int) htmlentities(trim($_POST['at_red_cards']));
?>