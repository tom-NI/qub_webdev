<?php
    include("../dbconn.php");

    // get the file name!
    $file = "resultsfinal.csv";

    // obtain and store the filepath
    $filepath = fopen($file, "r");

    // query database for info and return the variable
    function dbQueryAndReturnValue($query) {
        include("../dbconn.php");
        $value = $conn->query($query);
        if (!$value) {
            echo $conn->error;
            die();
        } else {
            $int = (int) $value->fetch_array()[0];
            return $int;
        }
    }

    // insert data and if it fails, print error message
    function dbInsertAndCheck($query) {
        include("../dbconn.php");
        $value = $conn->query($query);
        if (!$value) {
            echo $conn->error;
            die();
        }
    }

    // query a db and if data doesnt exist, insert it and check its inserted
    function avoidDuplicateEntries($query, $insertQueryIfNull) {
        include("../dbconn.php");
        $databaseReturnedObject = $conn->query($query);
        if (mysqli_num_rows($databaseReturnedObject) == 0) {
            dbInsertAndCheck($insertQueryIfNull);
        }
    }

    // loop thru full file, print out first item in each row!
    while ( ($line = fgetcsv($filepath)) !== FALSE ) {
        $season = real_escape_string($line[0]);
        $dateTime = real_escape_string($line[1]);
        $homeTeam = real_escape_string($line[2]);
        $awayTeam = real_escape_string($line[3]);
        $fullTimeHomeGoals = real_escape_string($line[4]);
        $fullTimeAwayGoals = real_escape_string($line[5]);
        $fullTimeResult = real_escape_string($line[6]);
        $halfTimeHomeGoals = real_escape_string($line[7]);
        $halfTimeAwayGoals = real_escape_string($line[8]);
        $halfTimeResult = real_escape_string($line[9]);
        $referee = real_escape_string($line[10]);
        $homeShots = real_escape_string($line[11]);
        $awayShots = real_escape_string($line[12]);
        $homeShotsOnTarget = real_escape_string($line[13]);
        $awayShotsOnTarget = real_escape_string($line[14]);
        $homeCorners = real_escape_string($line[15]);
        $awayCorners = real_escape_string($line[16]);
        $homeFouls = real_escape_string($line[17]);
        $awayFouls = real_escape_string($line[18]);
        $homeYellowCards = real_escape_string($line[19]);
        $awayYellowCards = real_escape_string($line[20]);
        $homeRedCards = real_escape_string($line[21]);
        $awayRedCards = real_escape_string($line[22]);

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
        
        avoidDuplicateEntries($sqlQuerySeason, $sqlInsertSeason);
        avoidDuplicateEntries($sqlQueryReferee, $sqlInsertReferee);
        avoidDuplicateEntries($sqlQueryHomeClubname, $sqlInsertHomeClubname);
        avoidDuplicateEntries($sqlQueryAwayClubname, $sqlInsertAwayClubname);

        // getseasonid for SQL query!
        $seasonIdQuery = "SELECT SeasonID FROM `epl_seasons` WHERE SeasonYears = '$season';";
        $seasonID = dbQueryAndReturnValue($seasonIdQuery);

        // find and return clubs ID;
        $homeClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$homeTeam';";
        $awayClubIDQuery = "SELECT ClubID FROM `epl_club_names` WHERE ClubName = '$awayTeam';";
        $homeClubID = dbQueryAndReturnValue($homeClubIDQuery);
        $awayClubID = dbQueryAndReturnValue($awayClubIDQuery);

        $refereeIDQuery = "SELECT RefereeID FROM `epl_referees` WHERE RefereeName = '$referee';";
        $refereeID = dbQueryAndReturnValue($refereeIDQuery);

        $sqlMatchInsertQuery = "INSERT INTO `epl_matches` (SeasonID, MatchDate, KickOffTime, RefereeID, HomeClubID, AwayClubId) 
                            VALUES ($seasonID, '$matchDate', '$kickOffTime', $refereeID, $homeClubID, $awayClubID);";
        dbInsertAndCheck($sqlMatchInsertQuery);

        $matchIDQuery = "SELECT MatchID FROM `epl_matches` WHERE MatchDate = '$matchDate' AND KickOffTime = '$kickOffTime' AND HomeClubID = $homeClubID;";
        
        $matchID = dbQueryAndReturnValue($matchIDQuery);
        $sqlHomeTeamStatsInsertQuery = "INSERT INTO `epl_home_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);";
        dbInsertAndCheck($sqlHomeTeamStatsInsertQuery);

        $sqlAwayTeamStatsInsertQuery = "INSERT INTO `epl_away_team_match_stats` (MatchID, TotalGoals, HalfTimeGoals, Shots, ShotsOnTarget, Corners, Fouls, YellowCards, RedCards) 
                            VALUES ($matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);";
        dbInsertAndCheck($sqlAwayTeamStatsInsertQuery); 
    }
?>