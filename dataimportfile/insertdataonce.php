<?php
    // TODO - 
    // GRAB FILE NAME
    // DELETE HEADER ROW IN CSV FILE
    // CHECK IF I CAN DELETE THE ROWS IN CSV FILE
    // COMMENT OUT ALL LIVE DB UPDATE QUERIES AND ECHO THEM FIRST
    // dummy echo out all lines from a dummy CSV file!

    // CHECK ALL CHECKS
    // CHECK ALL VARCHAR TYPES ARE ENCLOSED IN '' AND INTS ARE NOT!
    // SETUP MYSQL DATABASE FOR THE ROWS AND COLUMNS NAMES AND TABLES!
    // SETUP AI PK'S TO START FROM 1000 - J BUSCH SEEMS TO LIKE THIS

    // include("dbconn.php");

    // get the file name!
    $file = "dummyresults.csv";

    // obtain and store the filepath
    $filepath = fopen($file, "r");

    // query database for info and return the variable
    function dbQueryAndReturnValue($query) {
        $value = $conn->query($query);
        if (!$value) {
            echo $conn->error;
            die();
        } else {
            return $value;
        }
    }

    // insert data and if it fails, print error message
    // CHECK - IS THIS EVEN CORRECT LOL!
    function dbInsertAndCheck($query) {
        $value = $conn->query($query);
        if (!$value) {
            echo $conn->error;
            die();
        }
    }

    // query a db and if data doesnt exist, insert it and check its inserted
    function avoidDuplicateEntries($query, $insertQueryIfNull) {
        // CHECK top line of code
        if ($conn->query($query) == null) {
            dbInsertAndCheck($insertQueryIfNull);
        }
    }

    // loop thru full file, print out first item in each row!
    while ( ($line = fgetcsv($filepath)) !== FALSE ) {
        $season = $line[0];
        $dateTime = $line[1];
        $homeTeam = $line[2];
        $awayTeam = $line[3];
        $fullTimeHomeGoals = $line[4];
        $fullTimeAwayGoals = $line[5];
        $fullTimeResult = $line[6];  // todo - do i really need this?
        $halfTimeHomeGoals = $line[7];
        $halfTimeAwayGoals = $line[8];
        $halfTimeResult = $line[9];  // todo do i need this?
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

        // split the {ate and time for each row and assign into a var
        // used later on down the script to file the info!
        trim($dateTime);
        $dateTimearray = explode("T", $dateTime);
        $matchDate = $dateTimearray[0];
        $kickOffTime = $dateTimearray[1];

        // // query the normalised tables to ensure entries are not duplicated on import
        $sqlQuerySeason = "SELECT * FROM `epl_seasons` WHERE SeasonYears = '$season;'";
        $sqlInsertSeason = "INSERT INTO `epl_seasons` (SeasonYears) VALUES ('$season');";
        echo "<p>{$sqlQuerySeason}</p>";
        echo "<p>{$sqlInsertSeason}</p>";

        $sqlQueryReferee = "SELECT * FROM `epl_referees` WHERE RefereeName = '$referee;'";
        $sqlInsertReferee = "INSERT INTO `epl_referees` (RefereeName) VALUES ('$referee');";
        echo "<p>{$sqlQueryReferee}</p>";
        echo "<p>{$sqlInsertReferee}</p>";

        $sqlQueryHomeClubname = "SELECT * FROM `epl_club_names` WHERE ClubName = '$homeTeam';";
        $sqlInsertHomeClubname = "INSERT INTO `epl_club_names` (ClubName) VALUES ('$homeTeam');";
        echo "<p>{$sqlQueryHomeClubname}</p>";
        echo "<p>{$sqlInsertHomeClubname}</p>";

        $sqlQueryAwayClubname = "SELECT * FROM `epl_club_names` WHERE ClubName = '$awayTeam';";
        $sqlInsertAwayClubname = "INSERT INTO `epl_club_names` (ClubName) VALUES ('$awayTeam');";
        echo "<p>{$sqlQueryAwayClubname}</p>";
        echo "<p>{$sqlInsertAwayClubname}</p>";
        
        // avoidDuplicateEntries($sqlQuerySeason, $sqlInsertSeason);
        // avoidDuplicateEntries($sqlQueryReferee, $sqlInsertReferee);
        // avoidDuplicateEntries($sqlQueryHomeClubname, $sqlInsertHomeClubname);
        // avoidDuplicateEntries($sqlQueryAwayClubname, $sqlInsertAwayClubname);

        // // getseasonid for SQL query!
        $seasonIdQuery = "SELECT SeasonID FROM `epl_seasons` WHERE SeasonYears = '$season';";
        // $seasonID = dbQueryAndReturnValue($seasonIdQuery);
        echo "<p>{$seasonIdQuery}</p>";

        // // find and return clubs ID;
        $homeClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$homeTeam';";
        $awayClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$awayTeam';";
        // $homeClubID = dbQueryAndReturnValue($homeClubIDQuery);
        // $awayClubID = dbQueryAndReturnValue($awayClubIDQuery);
        echo "<p>{$homeClubIDQuery}</p>";
        echo "<p>{$awayClubIDQuery}</p>";

        $refereeIDQuery = "SELECT RefereeID FROM `epl_referees` WHERE RefereeName = '$referee';";
        // $refereeID = dbQueryAndReturnValue($refereeIDQuery);
        echo "<p>{$refereeIDQuery}</p>";
        
        // // TODO - make sure all strings have the ' ' around all string names and NOT around ints!
        $sqlMatchInsertQuery = "INSERT INTO `epl_matches` (SeasonID, MatchDate, KickOffTime, RefereeID, HomeClubID, AwayClubId) 
                            VALUES ($seasonID, '$matchDate', $kickOffTime, $refereeID, $homeclubID, $awayclubID);";
        // dbInsertAndCheck($sqlMatchInsertQuery);
        echo "<p>{$sqlMatchInsertQuery}</p>";

        // // TODO - CHECK THIS to get the current matchID
        $matchIDQuery = "SELECT MatchID FROM `epl_matches` WHERE MatchDate = '$matchDate' AND KickOffTime = '$kickOffTime' AND HomeClubID = $homeclubID;";
        // $matchID = dbQueryAndReturnValue($matchIDQuery);
        echo "<p>{$matchIDQuery}</p>";
            
        // // todo - get matchID
        $sqlHomeTeamStatsInsertQuery = "INSERT INTO `epl_home_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);";
        // dbInsertAndCheck($sqlHomeTeamStatsInsertQuery);
        echo "<p>{$sqlHomeTeamStatsInsertQuery}</p>";

        $sqlAwayTeamStatsInsertQuery = "INSERT INTO `epl_away_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);";
        // dbInsertAndCheck($sqlAwayTeamStatsInsertQuery); 
        echo "<p>{$sqlAwayTeamStatsInsertQuery}</p>";
    }
?>