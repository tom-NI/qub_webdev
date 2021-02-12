<?php
    require("dbconn.php");
    require("allfunctions.php");

    // obtain all form values safely first;
    $refereeQuery = real_escape_string(trim($_POST['refereeid']));    
    $seasonID = real_escape_string(trim($_POST['seasonID']));
    $matchDate = real_escape_string(trim($_POST['']));
    $kickOffTime = real_escape_string(trim($_POST['']));
    $refereeID = real_escape_string(trim($_POST['']));
    $homeClubID = real_escape_string(trim($_POST['homeclubID']));
    $awayClubID = real_escape_string(trim($_POST['awayclubID']));
    
    $homeTeamTotalGoals = real_escape_string(trim($_POST['']));
    $homeTeamHalfTimeGoals = real_escape_string(trim($_POST['']));
    $homeTeamShots = real_escape_string(trim($_POST['']));
    $homeTeamShotsOnTarget = real_escape_string(trim($_POST['']));
    $homeTeamCorners = real_escape_string(trim($_POST['']));
    $homeTeamFouls = real_escape_string(trim($_POST['']));
    $homeTeamYellowCards = real_escape_string(trim($_POST['']));
    $homeTeamRedCards = real_escape_string(trim($_POST['']));

    $awayTeamTotalGoals = real_escape_string(trim($_POST['']));
    $awayTeamHalfTimeGoals = real_escape_string(trim($_POST['']));
    $awayTeamShots = real_escape_string(trim($_POST['']));
    $awayTeamShotsOnTarget = real_escape_string(trim($_POST['']));
    $awayTeamCorners = real_escape_string(trim($_POST['']));
    $awayTeamFouls = real_escape_string(trim($_POST['']));
    $awayTeamYellowCards = real_escape_string(trim($_POST['']));
    $awayTeamRedCards = real_escape_string(trim($_POST['']));

    // check match logic for good quality data.
    // parse the date into the correct format?
    // TODO - CHECK THE DATE AND TIME ARE PARSED CORRECTLY!
    $getdate = date("Y-m-d H:i:s");
    if ($matchDate > now()) {
        echo "<p>Match date appears to be in the future, please enter historical records only</p>";
        die();
    }

    // Time cannot be > 10pm or before 9am - alert?
    if ($kickOffTime > 0) {
        
    }

    // Teams cannot be the same team - derived from the same list!
    if ($homeClubID == $awayClubID) {
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
            VALUES ({$seasonID},{$matchDate},{$kickOffTime},{$refereeID},{$homeClubID},{$awayClubID});
            SET @match_id = LAST_INSERT_ID();

            INSERT INTO epl_home_team_stats (`MatchID`,`HTTotalGoals`,`HTHalfTimeGoals`,`HTShots`,`HTShotsOnTarget`,`HTCorners`,`HTFouls`,`HTYellowCards`,`HTRedCards`) 
            VALUES (@match_id, {$homeTeamTotalGoals},{$homeTeamHalfTimeGoals},{$homeTeamShots},{$homeTeamShotsOnTarget},{$homeTeamCorners},{$homeTeamFouls},{$homeTeamYellowCards},{$homeTeamRedCards});

            INSERT INTO epl_away_team_stats (`MatchID`,`HTTotalGoals`,`HTHalfTimeGoals`,`HTShots`,`HTShotsOnTarget`,`HTCorners`,`HTFouls`,`HTYellowCards`,`HTRedCards`) 
            VALUES (@match_id, {$$matchDate}, {$awayTeamTotalGoals},{$awayTeamHalfTimeGoals},{$awayTeamShots},{$awayTeamShotsOnTarget},{$awayTeamCorners},{$awayTeamFouls},{$awayTeamYellowCards},{$awayTeamRedCards});
        COMMIT ";
    echo $updateTransaction;

    // dbQueryAndCheck($updateTransaction);
?>
