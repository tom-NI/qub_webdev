<?php
    require(__DIR__ . "/../logic_files/dbconn.php");
    require(__DIR__ . "/../logic_files/allfunctions.php");

    // get the file name!
    $file = "results.csv";

    // obtain and store the filepath
    $filepath = fopen($file, "r");

    // loop thru full file, print out first item in each row!
    while (($line = fgetcsv($filepath)) !== FALSE ) {
        $season = trim($line[0]);
        $dateTime = trim($line[1]);
        $homeTeam = trim($line[2]);
        $awayTeam = trim($line[3]);
        $fullTimeHomeGoals = trim($line[4]);
        $fullTimeAwayGoals = trim($line[5]);
        $fullTimeResult = trim($line[6]);
        $halfTimeHomeGoals = trim($line[7]);
        $halfTimeAwayGoals = trim($line[8]);
        $halfTimeResult = trim($line[9]);
        $referee = trim($line[10]);
        $homeShots = trim($line[11]);
        $awayShots = trim($line[12]);
        $homeShotsOnTarget = trim($line[13]);
        $awayShotsOnTarget = trim($line[14]);
        $homeCorners = trim($line[15]);
        $awayCorners = trim($line[16]);
        $homeFouls = trim($line[17]);
        $awayFouls = trim($line[18]);
        $homeYellowCards = trim($line[19]);
        $awayYellowCards = trim($line[20]);
        $homeRedCards = trim($line[21]);
        $awayRedCards = trim($line[22]);

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

        $sqlQuerySeason = "SELECT * FROM `epl_seasons` WHERE SeasonYears = ? ;";
        $sqlInsertSeason = "INSERT INTO `epl_seasons` (SeasonYears) VALUES ( ? );";
        insertAvoidingDuplicates($sqlQuerySeason, $sqlInsertSeason, "s", $tidiedSeasonYears);
        
        $sqlQueryReferee = "SELECT * FROM `epl_referees` WHERE RefereeName = ? ;";
        $sqlInsertReferee = "INSERT INTO `epl_referees` (RefereeName) VALUES ( ? );";
        insertAvoidingDuplicates($sqlQueryReferee, $sqlInsertReferee, "s", $cleanReferee);

        $sqlQueryClubname = "SELECT * FROM `epl_clubs` WHERE ClubName = ? ;";
        $sqlInsertClubname = "INSERT INTO `epl_clubs` (`ClubID`, `ClubName`, `ClubLogoURL`) VALUES (NULL, ?, NULL); ";
        insertAvoidingDuplicates($sqlQueryClubname, $sqlInsertClubname, "s", $homeTeam);
        insertAvoidingDuplicates($sqlQueryClubname, $sqlInsertClubname, "s", $awayTeam);

        $userIDForFlatFileImport = "Admin - flat file import";

        // insert match details first
        $stmt = $conn->prepare("INSERT INTO `epl_matches` (`MatchID`, `SeasonYears`, `MatchDate`, `KickOffTime`, `RefereeName`, `AddedByUserID`) VALUES (NULL, ?, ?, ?, ?, ?);");
        $stmt -> bind_param("sssss", $tidiedSeasonYears, $matchDate, $kickOffTime, $cleanReferee, $userIDForFlatFileImport);
        $stmt -> execute();
        $stmt -> store_result();
        $matchID = $conn -> insert_id;

        // insert home team records for that match
        $stmt = $conn->prepare("INSERT INTO `epl_home_team_stats` (`HomeTeamStatID`, `HomeClubName`, `MatchID`, `HTTotalGoals`, `HTHalfTimeGoals`, `HTShots`, `HTShotsOnTarget`, `HTCorners`, `HTFouls`, `HTYellowCards`, `HTRedCards`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ); ");
        $stmt -> bind_param("siiiiiiiii", $homeTeam, $matchID, $fullTimeHomeGoals, $halfTimeHomeGoals, $homeShots, $homeShotsOnTarget, $homeCorners, $homeFouls, $homeYellowCards, $homeRedCards);
        $stmt -> execute();

        // insert away team records for that match
        $stmt = $conn->prepare("INSERT INTO `epl_away_team_stats` (`AwayTeamStatID`, `AwayClubName`, `MatchID`, `ATTotalGoals`, `ATHalfTimeGoals`, `ATShots`, `ATShotsOnTarget`, `ATCorners`, `ATFouls`, `ATYellowCards`, `ATRedCards`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $stmt -> bind_param("siiiiiiiii", $awayTeam, $matchID, $fullTimeAwayGoals, $halfTimeAwayGoals, $awayShots, $awayShotsOnTarget, $awayCorners, $awayFouls, $awayYellowCards, $awayRedCards);
        $stmt -> execute();
    }
    echo "<h1>Upload to DB Successful</h1>";
?>