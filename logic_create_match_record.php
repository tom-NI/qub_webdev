<?php
    require("dbconn.php");
    require("allfunctions.php");

    // obtain all form values safely first;
    $seasonID = real_escape_string(trim($_POST['seasonID']));
    $finalSeasonID = htmlentities($seasonID);
    $matchDate = real_escape_string(trim($_POST['match_date']));
    $finalMatchDate = htmlentities($matchDate);
    $kickOffTime = real_escape_string(trim($_POST['kickoff_time']));
    $finalKickOffTime = htmlentities($kickOffTime);
    $refereeID = real_escape_string(trim($_POST['select_ref']));
    $finalRefereeID = htmlentities($refereeID);
    $homeClubID = real_escape_string(trim($_POST['homeclubID']));
    $finalHomeClubID = htmlentities($homeClubID);
    $awayClubID = real_escape_string(trim($_POST['awayclubID']));
    $finalAwayClubID = htmlentities($awayClubID);
    $homeTeamHalfTimeGoals = real_escape_string(trim($_POST['ht_ht_goals']));
    $finalHomeTeamHalfTimeGoals = htmlentities($homeTeamHalfTimeGoals);
    $homeTeamTotalGoals = real_escape_string(trim($_POST['ht_ft_goals']));
    $finalHomeTeamTotalGoals = htmlentities($homeTeamTotalGoals);
    $homeTeamShots = real_escape_string(trim($_POST['ht_total_shots']));
    $finalHomeTeamShots = htmlentities($homeTeamShots);
    $homeTeamShotsOnTarget = real_escape_string(trim($_POST['ht_shots_on_target']));
    $finalHomeTeamShotsOnTarget = htmlentities($homeTeamShotsOnTarget);
    $homeTeamCorners = real_escape_string(trim($_POST['ht_corners']));
    $finalHomeTeamCorners = htmlentities($homeTeamCorners);
    $homeTeamFouls = real_escape_string(trim($_POST['ht_total_fouls']));
    $finalHomeTeamFouls = htmlentities($homeTeamFouls);
    $homeTeamYellowCards = real_escape_string(trim($_POST['ht_yellow_cards']));
    $finalHomeTeamYellowCards = htmlentities($homeTeamYellowCards);
    $homeTeamRedCards = real_escape_string(trim($_POST['ht_red_cards']));
    $finalHomeTeamRedCards = htmlentities($homeTeamRedCards);

    $awayTeamHalfTimeGoals = real_escape_string(trim($_POST['at_ht_goals']));
    $finalAwayTeamHalfTimeGoals = htmlentities($awayTeamHalfTimeGoals);
    $awayTeamTotalGoals = real_escape_string(trim($_POST['at_ft_goals']));
    $finalAwayTeamTotalGoals = htmlentities($awayTeamTotalGoals);
    $awayTeamShots = real_escape_string(trim($_POST['at_total_shots']));
    $finalAwayTeamShots = htmlentities($awayTeamShots);
    $awayTeamShotsOnTarget = real_escape_string(trim($_POST['at_shots_on_target']));
    $finalAwayTeamShotsOnTarget = htmlentities($awayTeamShotsOnTarget);
    $awayTeamCorners = real_escape_string(trim($_POST['at_corners']));
    $finalAwayTeamCorners = htmlentities($awayTeamCorners);
    $awayTeamFouls = real_escape_string(trim($_POST['at_total_fouls']));
    $finalAwayTeamFouls = htmlentities($awayTeamFouls);
    $awayTeamYellowCards = real_escape_string(trim($_POST['at_yellow_cards']));
    $finalAwayTeamYellowCards = htmlentities($awayTeamYellowCards);
    $awayTeamRedCards = real_escape_string(trim($_POST['at_red_cards']));
    $finalAwayTeamRedCards = htmlentities($awayTeamRedCards);


    // check match logic for good quality data.
    // parse the date into the correct format?
    // TODO - CHECK THE DATE AND TIME ARE PARSED CORRECTLY!
    // $getdate = date("Y-m-d H:i:s");
    // if ($finalMatchDate > now()) {
    //     echo "<p>Match date appears to be in the future, please enter historical records only</p>";
    //     die();
    // }

    // // Time cannot be > 10pm or before 9am - alert?
    // if ($finalKickOffTime > 0) {
        
    // }

    // Teams cannot be the same team - derived from the same list!
    if ($finalHomeClubID == $finalAwayClubID) {
        echo "</p>Same club selected for both teams, please enter two different clubs.</p>";
        die();
    }
    
    // Shots on target cannot be > shots
    if (($finalHomeTeamshots < $finalHomeTeamShotsOnTarget) || ($finalAwayTeamShots < $finalHomeTeamShotsOnTarget)) {
        echo "<p>Shots cannot be greater than the shots on target, please reenter data.</p>";
        die();
    }

    // Half time goals cannot be > full time goals
    if (($finalHomeTeamHalfTimeGoals > $finalHomeTeamTotalGoals) || ($finalAwayTeamHalfTimeGoals > $finalAwayTeamTotalGoals)) {
        echo "<p>Half time goals cannot be greater than full time goals, please enter data again.</p>";
        die();
    }

    // Score cannot be less than total shots on target!
    if (($finalHomeTeamShotsOnTarget < $finalHomeTeamTotalGoals) || ($finalAwayTeamShotsOnTarget < $finalAwayTeamTotalGoals)) {
        echo "<p>Shots on Target cannot be less than goals scored!  Please check and enter data again.</p>";
        die();
    }

    // fouls should not be less than yellow + red cards
    if ($finalHomeTeamFouls < ($finalHomeTeamYellowCards + $finalHomeTeamRedCards) ||
        $finalAwayTeamFouls < ($finalAwayTeamYellowCards + $finalAwayTeamRedCards)) {
            echo "<p>Fouls are less than yellow cards + red cards, please check data and enter again,</p>";
            die();
    }

    // if all tests above pass, fairly sure the data is good, enter new match details;
    // TODO do i need to add this to the API?
    $updateTransaction = "
        START TRANSACTION;
            INSERT INTO epl_matches (`SeasonID`, `MatchDate`, `KickOffTime`, `RefereeID`, `HomeClubID`, `AwayClubID`) 
            VALUES ({$finalSeasonID},{$finalMatchDate},{$finalKickOffTime},{$finalRefereeID},{$finalHomeClubID},{$finalAwayClubID});
            SET @match_id = LAST_INSERT_ID();

            INSERT INTO epl_home_team_stats (`MatchID`,`HTTotalGoals`,`HTHalfTimeGoals`,`HTShots`,`HTShotsOnTarget`,`HTCorners`,`HTFouls`,`HTYellowCards`,`HTRedCards`) 
            VALUES (@match_id, {$finalHomeTeamTotalGoals},{$finalHomeTeamHalfTimeGoals},{$finalHomeTeamShots},{$finalHomeTeamShotsOnTarget},{$finalHomeTeamCorners},{$finalHomeTeamFouls},{$finalHomeTeamYellowCards},{$finalHomeTeamRedCards});

            INSERT INTO epl_away_team_stats (`MatchID`,`HTTotalGoals`,`HTHalfTimeGoals`,`HTShots`,`HTShotsOnTarget`,`HTCorners`,`HTFouls`,`HTYellowCards`,`HTRedCards`) 
            VALUES (@match_id, {$finalMatchDate}, {$finalAwayTeamTotalGoals},{$finalAwayTeamHalfTimeGoals},{$finalAwayTeamShots},{$finalAwayTeamShotsOnTarget},{$finalAwayTeamCorners},{$finalAwayTeamFouls},{$finalAwayTeamYellowCards},{$finalAwayTeamRedCards});
        COMMIT ";
    echo $updateTransaction;

    dbQueryAndCheck($updateTransaction);
?>
