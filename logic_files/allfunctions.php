<?php
    // query a db and if data doesnt exist, insert it and check its inserted
    // used for the initial load of flat file to db
    function insertAvoidingDuplicates($sqlQuery, $insertQueryIfNull) {
        require("dbconn.php");
        $conn->set_charset('utf8mb4');
        
        $sqlQuery = $mysqli->real_escape_string($sqlQuery);
        $finalSqlQuery = htmlentities($sqlQuery);
        $insertQueryIfNull = $mysqli->real_escape_string($insertQueryIfNull);
        $finalInsertQueryIfNull = htmlentities($insertQueryIfNull);

        $databaseReturnedObject = $conn->query($finalSqlQuery);
        if (mysqli_num_rows($databaseReturnedObject) == 0) {
            dbQueryAndCheck($finalInsertQueryIfNull);
        }
    }

    // query database for info and return the variable
    function dbQueryAndReturnIntValue($sqlQuery) {
        require("dbconn.php");
        $queryValue = $conn->query($sqlQuery);
        if (!$queryValue) {
            echo $conn->error;
            die();
        } else {
            // TODO - NEEDS TO HAVE THE INDEX OF THE COLUMN ADDED
            $int = (int) $queryValue->fetch_row();
            return $int;
        }
    }

    // insert data and if it fails, print error message
    function dbQueryAndCheck($sqlQuery) {
        require("dbconn.php");
        $queryValue = $conn->query($sqlQuery);
        if (!$queryValue) {
            echo $conn->error;
            die();
        }
    }

    function dbQueryCheckReturn($sqlQuery) {
        require("dbconn.php");
        $queriedValue = $conn->query($sqlQuery);
        if (!$queriedValue) {
            echo $conn->error;
            die();
        } else {
            return $queriedValue;
        }
    }

    function calculatePercentage($valueToDivide, $total) {
        if ($total != 0) {
            $percent = (double) ((double) $valueToDivide / (double)$total) * 100;
            $percentOneDP = number_format($percent, 1, '.', '');
            return "{$percentOneDP}";
        } else {
            return "0.0";
        }
    }

    function calculateAverage($valueToDivide, $total) {
        if ($total != 0) {
            $value = ((double) $valueToDivide / (double)$total);
            return number_format($value, 1, '.', '');
        } else {
            return "0.0";
        }
    }

    function calculateAverageTwoDP($valueToDivide, $total) {
        if ($total != 0) {
            $value = ((double) $valueToDivide / (double)$total);
            return number_format($value, 2, '.', '');
        } else {
            return "0.00";
        }
    }

    function getCurrentSeason() {
        $currentSeasonURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/list?current_season";
        require("../part_pages/api_auth.php");
        $currentSeasonData = file_get_contents($currentSeasonURL, false, $context);
        $currentSeasonArray = json_decode($currentSeasonData, true);

        foreach($currentSeasonArray as $row){
            $currentSeason = $row["currentSeason"];
        }
        return $currentSeason;
    }
    
    function checkSeasonYearOrder($fullSeasonEntryToCheck) {
        $seasonEntryArray = explode("-", $fullSeasonEntryToCheck);
        $seasonStartYear = (int) $seasonEntryArray[0];
        $seasonEndYear = (int) $seasonEntryArray[1];
        if ($seasonStartYear >= $seasonEndYear) {
            return false;
        } else {
            return true;
        }
    }
    
    function findNextSuggestedSeason() {
        $currentSeason = getCurrentSeason();
        $seasonYearsArray = explode("-", $currentSeason);
        $seasonEndYear = (int) $seasonYearsArray[1];
        $nextSeasonEndYear = $seasonEndYear + 1;
        return "{$seasonEndYear}-{$nextSeasonEndYear}";
    }

    function removeUnderScores($originalString) {
        $regex = '/[ ]/i';
        $newString = preg_replace($regex, ' ', $originalString);
        return $newString;
    }

    function addUnderScores($originalString) {
        $trimmedString = trim($originalString);
        $regex = '/[ ]/i';
        $newString = preg_replace($regex, '_', $trimmedString);
        return $newString;
    }

    function findMaxValueAndReturnTeam($arrayToCheck, $arrayTeamNames) {
        $maxVal = max($arrayToCheck);
        $maxIndex = array_search($maxVal, $arrayToCheck);
        return $arrayTeamNames[$maxIndex];
    }

    function findMinValueAndReturnTeam($arrayToCheck, $arrayTeamNames) {
        $minVal = min($arrayToCheck);
        $minIndex = array_search($minVal, $arrayToCheck);
        return $arrayTeamNames[$minIndex];
    }

    // parse the date from the database into a presentable long format
    function parseDateLongFormat($dateFromDB){
        $date = new DateTime($dateFromDB);
        return $date->format('l jS F Y');
    }

    function parseTimeForDBEntry($timeFromHTML){
        $date = new DateTime($timeFromHTML);
        return $date->format('H:i:s');
    }

    function searchAndAddToArray($valueToAdd, array $arrayToCheck, $itemIndex) {
        $valueAsInt = (int) trim($valueToAdd);
        if ((sizeof($arrayToCheck) - 1) >= $itemIndex) {
            $arrayToCheck[$itemIndex] += $valueAsInt;
        } else {
            array_push($arrayToCheck, $valueAsInt);
        }
        return $arrayToCheck;
    }

    function postDataInHeader($endpoint, $arrayToPost) {
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $arrayToPost
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($endpoint, false, $context);
        return $result;
    }

    // take a users Referee Name entry and parse into a format required for the database
    function parseRefereeName($userRefNameEntry) {
        // remove anything not a letter
        $nonLetterRegex = '/[^A-Za-z- .]/';
        $cleanedRefNameEntry = preg_replace($nonLetterRegex, '', $userRefNameEntry);
    
        // breakup into first and last names;
        $namesArray = explode(" ", $cleanedRefNameEntry);
        $firstName = $namesArray[0];
        $secondName = $namesArray[1];
        $firstInitial = strtoupper($firstName[0]);
        $secondNameFirstInitial = strtoupper($secondName[0]);
        $secondNameRemainder = strtolower(substr($secondName, 1, 40));
    
        $finalNameForDB = "{$firstInitial}. {$secondNameFirstInitial}{$secondNameRemainder}";
        return $finalNameForDB;
    }
?>