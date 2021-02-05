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

        // query the normalised tables to ensure entries are not duplicated on import
        $sqlQuerySeason = "SELECT * FROM `epl_seasons` WHERE SeasonYears = '$season';";
        $sqlInsertSeason = "INSERT INTO `epl_seasons` (SeasonYears) VALUES ('$season');";

        $sqlQueryReferee = "SELECT * FROM `epl_referees` WHERE RefereeName = '$referee';";
        $sqlInsertReferee = "INSERT INTO `epl_referees` (RefereeName) VALUES ('$referee');";

        $sqlQueryHomeClubname = "SELECT * FROM `epl_club_names` WHERE ClubName = '$homeTeam';";
        $sqlInsertHomeClubname = "INSERT INTO `epl_club_names` (ClubName) VALUES ('$homeTeam');";

        $sqlQueryAwayClubname = "SELECT * FROM `epl_club_names` WHERE ClubName = '$awayTeam';";
        $sqlInsertAwayClubname = "INSERT INTO `epl_club_names` (ClubName) VALUES ('$awayTeam');";
        
        insertAvoidingDuplicates($sqlQuerySeason, $sqlInsertSeason);
        insertAvoidingDuplicates($sqlQueryReferee, $sqlInsertReferee);
        insertAvoidingDuplicates($sqlQueryHomeClubname, $sqlInsertHomeClubname);
        insertAvoidingDuplicates($sqlQueryAwayClubname, $sqlInsertAwayClubname);

        // getseasonid for SQL query!
        $seasonIdQuery = "SELECT SeasonID FROM `epl_seasons` WHERE SeasonYears = '$season';";
        $seasonID = dbQueryAndReturnIntValue($seasonIdQuery);

        // find and return clubs ID;
        $homeClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$homeTeam';";
        $awayClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$awayTeam';";
        $homeClubID = dbQueryAndReturnIntValue($homeClubIDQuery);
        $awayClubID = dbQueryAndReturnIntValue($awayClubIDQuery);

        $refereeIDQuery = "SELECT RefereeID FROM `epl_referees` WHERE RefereeName = '$referee';";
        $refereeID = dbQueryAndReturnIntValue($refereeIDQuery);

        $sqlMatchInsertQuery = "INSERT INTO `epl_matches` (SeasonID, MatchDate, KickOffTime, RefereeID, HomeClubID, AwayClubId) 
                            VALUES ($seasonID, '$matchDate', '$kickOffTime', $refereeID, $homeClubID, $awayClubID);";
        dbInsertAndCheck($sqlMatchInsertQuery);

        $matchIDQuery = "SELECT MatchID FROM `epl_matches` WHERE MatchDate = '$matchDate' AND KickOffTime = '$kickOffTime' AND HomeClubID = $homeClubID;";
        
        $matchID = dbQueryAndReturnIntValue($matchIDQuery);
        $sqlHomeTeamStatsInsertQuery = "INSERT INTO `epl_home_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);";
        dbInsertAndCheck($sqlHomeTeamStatsInsertQuery);

        $sqlAwayTeamStatsInsertQuery = "INSERT INTO `epl_away_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);";
        dbInsertAndCheck($sqlAwayTeamStatsInsertQuery); 
    }
    echo "<p>Upload to DB Successful</p>";
?>