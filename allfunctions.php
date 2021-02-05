<?php
    require("dbconn.php");

    // query database for info and return the variable
    function dbQueryAndReturnIntValue($sqlQuery) {
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
        $databaseReturnedObject = $conn->query($sqlQuery);
        if (mysqli_num_rows($databaseReturnedObject) == 0) {
            dbInsertAndCheck($insertQueryIfNull);
        }
    }

    // insert data and if it fails, print error message
    function dbInsertAndCheck($sqlQuery) {
        $insertedValue = $conn->query($sqlQuery);
        if (!$insertedValue) {
            echo $conn->error;
            die();
        }
    }

?>