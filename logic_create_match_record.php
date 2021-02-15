<?php
    require("dbconn.php");
    require("allfunctions.php");

    // obtain all form values safely first;
    $refereeQuery = real_escape_string(trim($_POST['refereeid']));
    $finalRefQuery = htmlentities($refereeQuery);  
    $seasonID = real_escape_string(trim($_POST['seasonID']));
    $finalSeasonID = htmlentities($seasonID);
    $matchDate = real_escape_string(trim($_POST['']));
    $finalMatchDate = htmlentities($matchDate);
    $kickOffTime = real_escape_string(trim($_POST['']));
    $finalKickOffTime = htmlentities($kickOffTime);
    $refereeID = real_escape_string(trim($_POST['']));
    $finalRefereeID = htmlentities($refereeID);
    $homeClubID = real_escape_string(trim($_POST['homeclubID']));
    $finalHomeClubID = htmlentities($homeClubID);
    $awayClubID = real_escape_string(trim($_POST['awayclubID']));
    $finalAwayClubID = htmlentities($awayClubID);
    $homeTeamTotalGoals = real_escape_string(trim($_POST['']));
    $finalHomeTeamTotalGoals = htmlentities($homeTeamTotalGoals);
    $homeTeamHalfTimeGoals = real_escape_string(trim($_POST['']));
    $finalHomeTeamHalfTimeGoals = htmlentities($homeTeamHalfTimeGoals);
    $homeTeamShots = real_escape_string(trim($_POST['']));
    $finalHomeTeamShots = htmlentities($homeTeamShots);
    $homeTeamShotsOnTarget = real_escape_string(trim($_POST['']));
    $finalHomeTeamShotsOnTarget = htmlentities($homeTeamShotsOnTarget);

    $homeTeamCorners = real_escape_string(trim($_POST['']));
    $finalHomeTeamCorners = htmlentities($homeTeamCorners);
    $homeTeamFouls = real_escape_string(trim($_POST['']));
    $finalHomeTeamFouls = htmlentities($homeTeamFouls);
    $homeTeamYellowCards = real_escape_string(trim($_POST['']));
    $finalHomeTeamYellowCards = htmlentities($homeTeamYellowCards);
    $homeTeamRedCards = real_escape_string(trim($_POST['']));
    $finalHomeTeamRedCards = htmlentities($homeTeamRedCards);
    $awayTeamTotalGoals = real_escape_string(trim($_POST['']));
    $finalAwayTeamTotalGoals = htmlentities($awayTeamTotalGoals);
    $awayTeamHalfTimeGoals = real_escape_string(trim($_POST['']));
    $finalAwayTeamHalfTimeGoals = htmlentities($awayTeamHalfTimeGoals);
    $awayTeamShots = real_escape_string(trim($_POST['']));
    $finalAwayTeamShots = htmlentities($awayTeamShots);
    $awayTeamShotsOnTarget = real_escape_string(trim($_POST['']));
    $finalAwayTeamShotsOnTarget = htmlentities($awayTeamShotsOnTarget);
    $awayTeamCorners = real_escape_string(trim($_POST['']));
    $finalAwayTeamCorners = htmlentities($awayTeamCorners);
    $awayTeamFouls = real_escape_string(trim($_POST['']));
    $finalAwayTeamFouls = htmlentities($awayTeamFouls);
    $awayTeamYellowCards = real_escape_string(trim($_POST['']));
    $finalAwayTeamYellowCards = htmlentities($awayTeamYellowCards);
    $awayTeamRedCards = real_escape_string(trim($_POST['']));
    $finalAwayTeamRedCards = htmlentities($awayTeamRedCards);


    // check match logic for good quality data.
    // parse the date into the correct format?
    // TODO - CHECK THE DATE AND TIME ARE PARSED CORRECTLY!
    $getdate = date("Y-m-d H:i:s");
    if ($finalMatchDate > now()) {
        echo "<p>Match date appears to be in the future, please enter historical records only</p>";
        die();
    }

    // Time cannot be > 10pm or before 9am - alert?
    if ($finalKickOffTime > 0) {
        
    }

    // Teams cannot be the same team - derived from the same list!
    if ($finalHomeClubID == $finalAwayClubID) {
        echo "</p>Same club selected for both teams, please enter two different clubs.</p>";
        die();
    }
    
    // Shots on target cannot be > shots
    if (($homeTeamshots < $homeTeamShotsOnTarget) || ($awayTeamShots < $homeTeamShotsOnTarget)) {
        echo "<p>Shots cannot be greater than the shots on target, please reenter data.</p>";
        die();
    }

    // Half time goals cannot be > full time goals
    if (($homeTeamHalfTimeGoals > $homeTeamTotalGoals) || ($awayTeamHalfTimeGoals > $awayTeamTotalGoals)) {
        echo "<p>Half time goals cannot be greater than full time goals, please enter data again.</p>";
        die();
    }

    // Score cannot be less than total shots on target!
    if (($homeTeamShotsOnTarget < $homeTeamTotalGoals) || ($awayTeamShotsOnTarget < $awayTeamTotalGoals)) {
        echo "<p>Shots on Target cannot be less than goals scored!  Please check and enter data again.</p>";
        die();
    }

    // fouls should not be less than yellow + red cards
    if ($homeTeamFouls < ($homeTeamYellowCards + $homeTeamRedCards) ||
        $awayTeamFouls < ($awayTeamYellowCards + $awayTeamRedCards)) {
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

    // dbQueryAndCheck($updateTransaction);
?>
