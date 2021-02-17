<?php
    require("dbconn.php");

    // query a db and if data doesnt exist, insert it and check its inserted
    function insertAvoidingDuplicates($sqlQuery, $insertQueryIfNull) {
        require("dbconn.php");
        $databaseReturnedObject = $conn->query($sqlQuery);
        if (mysqli_num_rows($databaseReturnedObject) == 0) {
            dbQueryAndCheck($insertQueryIfNull);
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

    function checkSeasonRegex($stringToCheck) {
        $seasonRegex = '/2[0-9]{3}-2[0-9]{3}/';
        if (preg_match($seasonRegex, $stringToCheck)) {
            return true;
        } else {
            return false;
        }
    }

    function calculatePercentage($valueToDivide, $total) {
        if ($total != 0) {
            $percent = (double) ((double) $valueToDivide / (double)$total) * 100;
            $percentOneDP = number_format($percent, 1, '.', '');
            return "{$percentOneDP}%";
        } else {
            return "0.0%";
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

    function getCurrentSeason() {
        $currentSeasonURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=current_season";
        $currentSeasonData = file_get_contents($currentSeasonURL);
        $currentSeasonArray = json_decode($currentSeasonData, true);
        // todo - get the array digit off the array item!
        $currentSeason = $currentSeasonArray->fetch_row();
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
        $seasonStartYear = (int) $seasonYearsArray[0];
        $seasonEndYear = (int) $seasonYearsArray[1];
        $nextSeasonEndYear = $seasonEndYear + 1;
        return "{$seasonEndYear}-{$nextSeasonEndYear}";
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
?>