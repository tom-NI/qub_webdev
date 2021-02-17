<?php
    require("../dbconn.php");
    require("../allfunctions.php");

    // get the file name!
    $file = "resultsfinal.csv";

    // obtain and store the filepath
    $filepath = fopen($file, "r");

    // loop thru full file, print out first item in each row!
    while ( ($line = fgetcsv($filepath)) !== FALSE ) {
        $season = $line[0];
        $dateTime = $line[1];
        $homeTeam = $line[2];
        $awayTeam = $line[3];
        $fullTimeHomeGoals = $line[4];
        $fullTimeAwayGoals = $line[5];
        $fullTimeResult = $line[6]; 
        $halfTimeHomeGoals = $line[7];
        $halfTimeAwayGoals = $line[8];
        $halfTimeResult = $line[9]; 
        $referee = $line[10];
        $homeShots = $line[11];
        $awayShots = $line[12];
        $homeShotsOnTarget = $line[13];
        $awayShotsOnTarget = $line[14];
        $homeCorners = $line[15];
        $awayCorners = $line[16];
        $homeFouls = $line[17];
        $awayFouls = $line[18];
        $homeYellowCards = $line[19];
        $awayYellowCards = $line[20];
        $homeRedCards = $line[21];
        $awayRedCards = $line[22];

        // split the date and time for each row and assign into a var
        // used later on down the script to file the info into db match info!
        trim($dateTime);
        $dateTimearray = explode("T", $dateTime);
        $matchDate = $dateTimearray[0];

        // save match time without the Z from csv
        $regex = '/[Zz]/i';
        $kaggleKickOffTime = $dateTimearray[1];
        $kickOffTime = preg_replace($regex, '', $kaggleKickOffTime);
        // if the kick off time isnt set in the CSV, set it to null in the database
        if ($kickOffTime == "00:00:00") {
            $kickOffTime = null;
        }

        // tidy up season year data
        $seasonYearsArray = explode("-", $season);
        $firstYear = $seasonYearsArray[0];
        $secondYear = $seasonYearsArray[1];
        // remove odd CSV characters from the season years
        $nonNumberRegex = '/[^A-Za-z0-9]/';
        $cleanFirstYear = preg_replace($nonNumberRegex, '', $firstYear);
        $cleanSecondYear = preg_replace($nonNumberRegex, '', $secondYear);
        // add "20" to the start of the second year digits
        $seasonSecondYear = "20{$cleanSecondYear}";
        $tidiedSeasonYears = "{$cleanFirstYear}-{$seasonSecondYear}";

        $refereeRegex = '/[^A-Za-z0-9. ]/';
        $cleanReferee = preg_replace($refereeRegex, '', $referee);

        // query the normalised tables to ensure entries are not duplicated on import
        $sqlQuerySeason = "SELECT * FROM `epl_seasons` WHERE SeasonYears = '$tidiedSeasonYears';";
        $sqlInsertSeason = "INSERT INTO `epl_seasons` (SeasonYears) VALUES ('$tidiedSeasonYears');";

        $sqlQueryReferee = "SELECT * FROM `epl_referees` WHERE RefereeName = '$cleanReferee';";
        $sqlInsertReferee = "INSERT INTO `epl_referees` (RefereeName) VALUES ('$cleanReferee');";

        $sqlQueryHomeClubname = "SELECT * FROM `epl_clubs` WHERE ClubName = '$homeTeam';";
        $sqlInsertHomeClubname = "INSERT INTO `epl_clubs` (ClubName) VALUES ('$homeTeam');";

        $sqlQueryAwayClubname = "SELECT * FROM `epl_clubs` WHERE ClubName = '$awayTeam';";
        $sqlInsertAwayClubname = "INSERT INTO `epl_clubs` (ClubName) VALUES ('$awayTeam');";
        
        insertAvoidingDuplicates($sqlQuerySeason, $sqlInsertSeason);
        insertAvoidingDuplicates($sqlQueryReferee, $sqlInsertReferee);
        insertAvoidingDuplicates($sqlQueryHomeClubname, $sqlInsertHomeClubname);
        insertAvoidingDuplicates($sqlQueryAwayClubname, $sqlInsertAwayClubname);

        // getseasonid for SQL query!
        $seasonIdQuery = "SELECT SeasonID FROM `epl_seasons` WHERE SeasonYears = '$tidiedSeasonYears';";
        $seasonID = dbQueryAndReturnIntValue($seasonIdQuery);

        // find and return clubs ID;
        $homeClubIDQuery = "SELECT ClubID FROM `epl_clubs` WHERE ClubName = '$homeTeam';";
        $awayClubIDQuery = "SELECT ClubID FROM `epl_clubs` WHERE ClubName = '$awayTeam';";
        $homeClubID = dbQueryAndReturnIntValue($homeClubIDQuery);
        $awayClubID = dbQueryAndReturnIntValue($awayClubIDQuery);

        $refereeIDQuery = "SELECT RefereeID FROM `epl_referees` WHERE RefereeName = '$cleanReferee';";
        $refereeID = dbQueryAndReturnIntValue($refereeIDQuery);

        $sqlMatchInsertQuery = "INSERT INTO `epl_matches` (SeasonID, MatchDate, KickOffTime, RefereeID) 
                            VALUES ($seasonID, '$matchDate', '$kickOffTime', $refereeID);";
        dbQueryAndCheck($sqlMatchInsertQuery);

        $matchIDQuery = "SELECT MAX(MatchID) FROM `epl_matches`;";
        $matchID = dbQueryAndReturnIntValue($matchIDQuery);

        $sqlHomeTeamStatsInsertQuery = "INSERT INTO `epl_home_team_stats` (HomeClubID, MatchID, HTTotalGoals, HTHalfTimeGoals, HTShots, HTShotsOnTarget, HTCorners, HTFouls, HTYellowCards, HTRedCards) 
                            VALUES ($homeClubID, $matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);";
        dbQueryAndCheck($sqlHomeTeamStatsInsertQuery);

        $sqlAwayTeamStatsInsertQuery = "INSERT INTO `epl_away_team_stats` (AwayClubID, MatchID, ATTotalGoals, ATHalfTimeGoals, ATShots, ATShotsOnTarget, ATCorners, ATFouls, ATYellowCards, ATRedCards) 
                            VALUES ($awayClubID, $matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);";
        dbQueryAndCheck($sqlAwayTeamStatsInsertQuery); 
    }
    echo "<p>Upload to DB Successful</p>";
?>