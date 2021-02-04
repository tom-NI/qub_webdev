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

        echo "<p>season name {$season}</p>";
        echo "<p>dateTime {$dateTime}</p>";
        echo "<p>homeTeam {$homeTeam}</p>";
        echo "<p>away team {$awayTeam}</p>";
        echo "<p>fullTimeHomeGoals {$fullTimeHomeGoals}</p>";
        echo "<p>fullTimeAwayGoals {$fullTimeAwayGoals}</p>";
        echo "<p>fullTimeResult {$fullTimeResult}</p>";
        echo "<p>halfTimeHomeGoals {$halfTimeHomeGoals}</p>";
        echo "<p>halfTimeAwayGoals {$halfTimeAwayGoals}</p>";
        echo "<p>halfTimeResult {$halfTimeResult}</p>";
        echo "<p>referee {$referee}</p>";
        echo "<p>homeShots {$homeShots}</p>";
        echo "<p>awayShots {$awayShots}</p>";
        echo "<p>homeShotsOnTarget {$homeShotsOnTarget}</p>";
        echo "<p>awayShotsOnTarget {$awayShotsOnTarget}</p>";
        echo "<p>homeCorners {$homeCorners}</p>";
        echo "<p>awayCorners {$awayCorners}</p>";
        echo "<p>homeFouls {$homeFouls}</p>";
        echo "<p>awayFouls {$awayFouls}</p>";
        echo "<p>homeYellowCards {$homeYellowCards}</p>";
        echo "<p>awayYellowCards {$awayYellowCards}</p>";
        echo "<p>homeRedCards {$homeRedCards}</p>";
        echo "<p>awayRedCards {$awayRedCards}</p>";

        // split the {ate and time for each row and assign into a var
        // used later on down the script to file the info!
        trim($dateTime);
        $dateTimearray = explode("T", $dateTime);
        $matchDate = $dateTimearray[0];
        $kickOffTime = $dateTimearray[1];

        echo "<p>split out date {$matchDate}</p>";
        echo "<p>split pout time {$kickOffTime}</p>";

        // // query the normalised tables to ensure entries are not duplicated on import
        // $sqlQuerySeason = "SELECT * FROM seasons WHERE SeasonYears = $season;";
        // $sqlInsertSeason = "INSERT INTO seasons (SeasonYears) VALUES ('$season');";

        // $sqlQueryReferee = "SELECT * FROM referee WHERE RefereeName = $referee;";
        // $sqlInsertReferee = "INSERT INTO referee (RefereeName) VALUES $referee;";

        // $sqlQueryHomeClubname = "SELECT * FROM club_names WHERE ClubName = $homeTeam;";
        // $sqlInsertHomeClubname = "INSERT INTO club_names (ClubName) VALUES ($homeTeam);";

        // $sqlQueryAwayClubname = "SELECT * FROM club_names WHERE ClubName = $awayTeam;";
        // $sqlInsertAwayClubname = "INSERT INTO club_names (ClubName) VALUES ($awayTeam);";
        
        // avoidDuplicateEntries($sqlQuerySeason, $sqlInsertSeason);
        // avoidDuplicateEntries($sqlQueryReferee, $sqlInsertReferee);
        // avoidDuplicateEntries($sqlQueryHomeClubname, $sqlInsertHomeClubname);
        // avoidDuplicateEntries($sqlQueryAwayClubname, $sqlInsertAwayClubname);

        // // getseasonid for SQL query!
        // $seasonIdQuery = "SELECT SeasonID FROM seasons WHERE SeasonYears = $season;";
        // $seasonID = dbQueryAndReturnValue($seasonIdQuery);

        // // find and return clubs ID;
        // $homeClubIDQuery = "SELECT ClubID FROM club_names WHERE ClubName = $homeTeam;";
        // $awayClubIDQuery = "SELECT ClubID FROM club_names WHERE ClubName = $awayTeam;";
        // $homeClubID = dbQueryAndReturnValue($homeClubIDQuery);
        // $awayClubID = dbQueryAndReturnValue($awayClubIDQuery);

        // $refereeIDQuery = "SELECT RefereeID FROM referee WHERE RefereeName = $referee;";
        // $refereeID = dbQueryAndReturnValue($refereeIDQuery);
        
        // // TODO - make sure all strings have the ' ' around all string names and NOT around ints!
        // $sqlMatchInsertQuery = "INSERT INTO matches (SeasonID, MatchDate, KickOffTime, Referee, HomeClubID, AwayClubId, HalfTimeResult, FullTimeResult) 
        //                     VALUES ($seasonID, $matchDate, $kickOffTime, $refereeID, $homeclubID, $awayclubID, $halfTimeResult, $fullTimeResult);";
        // dbInsertAndCheck($sqlMatchInsertQuery);

        // // TODO - CHECK THIS to get the current matchID
        // $matchIDQuery = "SELECT MatchID FROM matches WHERE MatchDate = $matchDate AND KickOffTime = $kickOffTime AND HomeClubID = $homeclubID;";
        // $matchID = dbQueryAndReturnValue($matchIDQuery);
            
        // // todo - get matchID
        // $sqlHomeTeamStatsInsertQuery = "INSERT INTO home_team_match_stats (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
        //                     VALUES ($matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);";
        // dbInsertAndCheck($sqlHomeTeamStatsInsertQuery);

        // $sqlAwayTeamStatsInsertQuery = "INSERT INTO home_team_match_stats (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
        //                     VALUES ($matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);";
        // dbInsertAndCheck($sqlAwayTeamStatsInsertQuery); 
    }
?>