<?php
    require("dbconn.php");
    require("allfunctions.php");

    // obtain all form values safely first;
    $seasonID = trim($_POST['seasonID']);
    $finalSeasonID = htmlentities($seasonID);
    $matchDate = trim($_POST['match_date']);
    $finalMatchDate = htmlentities($matchDate);
    $kickOffTime = trim($_POST['kickoff_time']);
    $finalKickOffTime = htmlentities($kickOffTime);
    $refereeID = trim($_POST['select_ref']);
    $finalRefereeID = htmlentities($refereeID);
    $homeClubName = trim($_POST['ht_selector']);
    $finalHomeClubID = htmlentities($homeClubName);
    $awayClubName = trim($_POST['at_selector']);
    $finalAwayClubID = htmlentities($awayClubName);
    $homeTeamHalfTimeGoals = trim($_POST['ht_ht_goals']);
    $finalHomeTeamHalfTimeGoals = htmlentities($homeTeamHalfTimeGoals);
    $homeTeamTotalGoals = trim($_POST['ht_ft_goals']);
    $finalHomeTeamTotalGoals = htmlentities($homeTeamTotalGoals);
    $homeTeamShots = trim($_POST['ht_total_shots']);
    $finalHomeTeamShots = htmlentities($homeTeamShots);
    $homeTeamShotsOnTarget = trim($_POST['ht_shots_on_target']);
    $finalHomeTeamShotsOnTarget = htmlentities($homeTeamShotsOnTarget);
    $homeTeamCorners = trim($_POST['ht_corners']);
    $finalHomeTeamCorners = htmlentities($homeTeamCorners);
    $homeTeamFouls = trim($_POST['ht_total_fouls']);
    $finalHomeTeamFouls = htmlentities($homeTeamFouls);
    $homeTeamYellowCards = trim($_POST['ht_yellow_cards']);
    $finalHomeTeamYellowCards = htmlentities($homeTeamYellowCards);
    $homeTeamRedCards = trim($_POST['ht_red_cards']);
    $finalHomeTeamRedCards = htmlentities($homeTeamRedCards);

    $awayTeamHalfTimeGoals = trim($_POST['at_ht_goals']);
    $finalAwayTeamHalfTimeGoals = htmlentities($awayTeamHalfTimeGoals);
    $awayTeamTotalGoals = trim($_POST['at_ft_goals']);
    $finalAwayTeamTotalGoals = htmlentities($awayTeamTotalGoals);
    $awayTeamShots = trim($_POST['at_total_shots']);
    $finalAwayTeamShots = htmlentities($awayTeamShots);
    $awayTeamShotsOnTarget = trim($_POST['at_shots_on_target']);
    $finalAwayTeamShotsOnTarget = htmlentities($awayTeamShotsOnTarget);
    $awayTeamCorners = trim($_POST['at_corners']);
    $finalAwayTeamCorners = htmlentities($awayTeamCorners);
    $awayTeamFouls = trim($_POST['at_total_fouls']);
    $finalAwayTeamFouls = htmlentities($awayTeamFouls);
    $awayTeamYellowCards = trim($_POST['at_yellow_cards']);
    $finalAwayTeamYellowCards = htmlentities($awayTeamYellowCards);
    $awayTeamRedCards = trim($_POST['at_red_cards']);
    $finalAwayTeamRedCards = htmlentities($awayTeamRedCards);

    $matchDateInThePast = false;
    $startTimeWithinLimits = false;
    $notTheSameTeams = false;
    $shotsAreGreaterThanShotsOT = false;
    $halfTimeGoalsLessThanFullTime = false;
    $shotsOTisntLessThanGoals = false;
    $foulsLessThanTotalCards = false;
    $currentSeasonSelected = false;

    // TODO - CHECK THE DATE AND TIME ARE PARSED CORRECTLY!
    $getdate = date("Y-m-d H:i:s");
    if ($finalMatchDate > now()) {
        $matchDateInThePast = false;
        $resultString += "Match date appears to be in the future, please enter historical records only. ";
    } else {
        $matchDateInThePast = true;
    }

    // Time cannot be > 10pm or before 9am - alert?
    if ($finalKickOffTime > 0) {
        $startTimeWithinLimits = false;
        $resultString += "Start time appears to have been set for a night time start.  Please Enter times during the day within the GMT timezone.    ";
    } else {
        $startTimeWithinLimits = true;
    }

    // get current season from DB!
    $currentSeason = getCurrentSeason();
    if ($finalSeasonID != $currentSeason) {
        $currentSeasonSelected = false;
        $resultString += "Current Season has not been selected, historic seasons cannot have results added.  ";
    } else {
        $currentSeasonSelected = true;
    }

    // Teams cannot be the same team - derived from the same list!
    if ($finalHomeClubID == $finalAwayClubID) {
        $resultString += "Same club selected for both teams, please enter two different clubs.  ";
        $notTheSameTeams = false;
    } else {
        $notTheSameTeams = true;
    }
    
    // Shots on target cannot be > shots
    if (($finalHomeTeamShots < $finalHomeTeamShotsOnTarget) || ($finalAwayTeamShots < $finalHomeTeamShotsOnTarget)) {
        $resultString += "Shots cannot be greater than the shots on target, please reenter data.  ";
        $shotsAreGreaterThanShotsOT = false;
    } else {
        $shotsAreGreaterThanShotsOT = true;
    }

    // Half time goals cannot be > full time goals
    if (($finalHomeTeamHalfTimeGoals > $finalHomeTeamTotalGoals) || ($finalAwayTeamHalfTimeGoals > $finalAwayTeamTotalGoals)) {
        $resultString += "Half time goals cannot be greater than full time goals, please enter data again.  ";
        $halfTimeGoalsLessThanFullTime = false;
    } else {
        $halfTimeGoalsLessThanFullTime = true;
    }

    // Score cannot be less than total shots on target!
    if (($finalHomeTeamShotsOnTarget < $finalHomeTeamTotalGoals) || ($finalAwayTeamShotsOnTarget < $finalAwayTeamTotalGoals)) {
        $resultString += "Shots on Target cannot be less than goals scored!  Please check and enter data again.  ";
        $shotsOTisntLessThanGoals = false;
    } else {
        $shotsOTisntLessThanGoals = true;
    }

    // fouls should not be less than yellow + red cards
    if ($finalHomeTeamFouls < ($finalHomeTeamYellowCards + $finalHomeTeamRedCards) ||
        $finalAwayTeamFouls < ($finalAwayTeamYellowCards + $finalAwayTeamRedCards)) {
            $foulsLessThanTotalCards = false;
            $resultString += "Fouls are less than yellow cards + red cards, please check data and enter again.  ";
    } else {
        $foulsLessThanTotalCards = true;
    }

    // if all flags are true, fairly sure isnt bad, enter new match details;
    // TODO do i need to add this to the API?
    // todo add $matchDateInThePast;
    // todo add $startTimeWithinLimits
    if ($notTheSameTeams 
        && $shotsAreGreaterThanShotsOT 
        && $halfTimeGoalsLessThanFullTime 
        && $shotsOTisntLessThanGoals 
        && $foulsLessThanTotalCards
        && $currentSeasonSelected) {
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
            $resultString = "Match Entry has been successful";
    }
?>

<!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <script src='https://kit.fontawesome.com/06c5b011c2.js' crossorigin='anonymous'></script>
        <link rel='stylesheet' href='mystyles.css'>
        <title>EPL Match Result Entry</title>
    </head>

    <body class='has-navbar-fixed-top is-family-sans-serif'>
        <?php include("part_site_navbar.php"); ?>

        <section class='hero is-info is-bold pt-6'>
            <div class='hero-body'>
                <div class='container'>
                    <h1 class='title mt-4'>Match Entry</h1>
                </div>
            </div>
        </section>

        <div class='has-text-centered master_site_width container columns' id='my_upload_result_form'>
            <div class='column is-8 is-offset-2'>
                <div class='mt-5 p-5 my_info_colour'> 
                    <?php echo "<h2 class='subtitle is-5 my_info_colour'>{$resultString}</h2>"?>
                    <a type='button' class='my_info_colour' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_add_new_result.php'> Return to previous page</a>
                </div>
            </div>
        </div>
            <?php 
                include('part_site_footer.php'); 
            ?>
        <script src='my_script.js'></script>
    </body>
    </html>
