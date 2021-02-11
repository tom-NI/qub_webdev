<?php
    require("dbconn.php");

    // query database for info and return the variable
    function dbQueryAndReturnIntValue($sqlQuery) {
        require("dbconn.php");
        $queryValue = $conn->query($sqlQuery);
        if (!$queryValue) {
            echo $conn->error;
            die();
        } else {
            $int = (int) $queryValue->fetch_array()[0];
            return $int;
        }
    }

    // query a db and if data doesnt exist, insert it and check its inserted
    function insertAvoidingDuplicates($sqlQuery, $insertQueryIfNull) {
        require("dbconn.php");
        $databaseReturnedObject = $conn->query($sqlQuery);
        if (mysqli_num_rows($databaseReturnedObject) == 0) {
            dbQueryAndCheck($insertQueryIfNull);
        }
    }

    // insert data and if it fails, print error message
    function dbQueryAndCheck($sqlQuery) {
        require("dbconn.php");
        $insertedValue = $conn->query($sqlQuery);
        if (!$insertedValue) {
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
        $regex = '/[_]/i';
        $newString = preg_replace($regex, ' ', $originalString);
        return $newString;
    }

?>