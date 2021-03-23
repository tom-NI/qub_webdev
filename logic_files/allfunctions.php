<?php
    // php mailer dependency
    use PHPMailer\PHPMailer\PHPMailer;

    // query a db and if data doesnt exist, insert it and check its inserted
    // used for the initial load of flat CSV file to db, NOT for all prepared statements
    function insertAvoidingDuplicates($checkingStatement, $insertStatement, $datatype, $valueToCheck) {
        require("dbconn.php");
        $conn->set_charset('utf8mb4');

        $stmt = $conn->prepare($checkingStatement);
        $stmt -> bind_param($datatype, $valueToCheck);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> fetch();
        if ($stmt->num_rows == 0) {
            $insertStmt = $conn->prepare($insertStatement);
            $insertStmt -> bind_param($datatype, $valueToCheck);
            $insertStmt -> execute();
            $insertStmt->close();
        }
        $stmt->close();
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

    // query the db and if successful, return the value asked for
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

    // calculate and return percentage as a double to 1 decimal place
    function calculatePercentage($valueToDivide, $total) {
        if ($total != 0) {
            $percent = (double) ((double) $valueToDivide / (double)$total) * 100;
            $percentOneDP = number_format($percent, 1, '.', '');
            return "{$percentOneDP}";
        } else {
            return "0.0";
        }
    }

    // calculate percentage and round to the nearest whole int
    function calculatePercentageAsInt($valueToDivide, $total) {
        if ($total != 0) {
            $percent = ((double) $valueToDivide / (double)$total) * 100;
            $percent = round($percent, 0, PHP_ROUND_HALF_UP);
            return $percent;
        } else {
            return "0";
        }
    }

    // calculate the average as a double to one decimal place
    function calculateAverage($valueToDivide, $total) {
        if ($total != 0) {
            $value = ((double) $valueToDivide / (double)$total);
            return number_format($value, 1, '.', '');
        } else {
            return "0.0";
        }
    }

    // calculate the average to two DP
    function calculateAverageTwoDP($valueToDivide, $total) {
        if ($total != 0) {
            $value = ((double) $valueToDivide / (double)$total);
            return number_format($value, 2, '.', '');
        } else {
            return "0.00";
        }
    }

    // get and return the current season via the API
    function getCurrentSeason() {
        $currentSeasonURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/seasons?current_season";
        $currentSeasonData = postDevKeyInHeader($currentSeasonURL);
        $currentSeasonArray = json_decode($currentSeasonData, true);

        foreach($currentSeasonArray as $row){
            $currentSeason = $row["currentSeason"];
        }
        return $currentSeason;
    }
    
    // check the order of season years is correct (for parsing user inputs)
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
    
    // find the next season (to display the suggested next season to admins when adding seasons)
    function findNextSuggestedSeason() {
        // get current max season in the DB!
        $currentSeasonURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/seasons?all_seasons_list";
        $currentSeasonData = postDevKeyInHeader($currentSeasonURL);
        $currentSeasonArray = json_decode($currentSeasonData, true);
        $maxSeason = $currentSeasonArray[0]['season'];
        
        $seasonYearsArray = explode("-", $maxSeason);
        $seasonEndYear = (int) $seasonYearsArray[1];
        $nextSeasonEndYear = $seasonEndYear + 1;
        return "{$seasonEndYear}-{$nextSeasonEndYear}";
    }

    // remove underscores from data
    function removeUnderScores($originalString) {
        $regex = '/[_]/i';
        $newString = preg_replace($regex, ' ', $originalString);
        return $newString;
    }

    // add underscores to team names for searches
    function addUnderScores($originalString) {
        $trimmedString = trim($originalString);
        $regex = '/[ ]/i';
        $newString = preg_replace($regex, '_', $trimmedString);
        return $newString;
    }

    // find the maximum value in an array and return the equivalent items (same index) from another array
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

    // parse date for short format for presentation
    function parseDateShortFormat($dateFromDB){
        $date = new DateTime($dateFromDB);
        return $date->format('jS M Y');
    }

    // get the time that a users input from HTML and make it consistent for DB entry
    function parseTimeForDBEntry($timeFromHTML){
        $date = new DateTime($timeFromHTML);
        return $date->format('H:i:s');
    }

    // check if an item is in an array and alter the array to suit if not
    function searchAndAddToArray($valueToAdd, array $arrayToCheck, $itemIndex) {
        $valueAsInt = (int) trim($valueToAdd);
        if ((sizeof($arrayToCheck) - 1) >= $itemIndex) {
            $arrayToCheck[$itemIndex] += $valueAsInt;
        } else {
            array_push($arrayToCheck, $valueAsInt);
        }
        return $arrayToCheck;
    }

    // post the main administrators API key in the header with the endpoint argument given
    // used for all API requests throughout the website
    function postDevKeyInHeader($endpoint) {
        require(__DIR__ . "/../site_api_auth/auth.php");
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Authorization: Basic ".base64_encode("$orgName:$keyValue")
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($endpoint, false, $context);
        if (!$result) {
            return http_response_code(500);
        } else {
            return $result;
        }
    }

    // call this function when you need to post an array of data with the dev key
    function postDevKeyWithData($endpoint, $dataArrayToPost) {
        require(__DIR__ . "/../site_api_auth/auth.php");
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => ["Authorization: Basic ".base64_encode("$orgName:$keyValue"), 
                    'Content-Type: application/x-www-form-urlencoded'],
                'content' => $dataArrayToPost
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($endpoint, false, $context);
        if (!$result) {
            return http_response_code(500);
        } else {
            return $result;
        }
    }

    // take a users Referee Name entry and parse into a strict format required for the database
    // used to keep data input quality high
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

    // send an email using PHPMailer
    function sendEmail($userEmail, $userFirstName, $emailBody, $emailSubject, $emailFrom) {
        // php mailer will send the user an email
        require (__DIR__ . '/../php_mailer_master/src/PHPMailer.php');
        require (__DIR__ . '/../php_mailer_master/src/SMTP.php');
        require (__DIR__ . '/../php_mailer_master/src/Exception.php');
        $mail = new PHPMailer(TRUE);

        try {
            $mail->setFrom('tkilpatrick01@qub.ac.uk', "{$emailFrom}");
            $mail->addAddress("$userEmail", "$userFirstName");
            $mail->Subject = $emailSubject;
            $mail->Body = $emailBody;
            $mail->isHTML(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = TRUE;
            $mail->SMTPSecure = 'STARTTLS';
            $mail->Username = '40314543@ads.qub.ac.uk';
            $mail->Password = 'LearnMore*-2020*';
            $mail->Port = 587;
        
            $mail->send();
        } catch (Exception $e) {
            // $displayMessage = $e->errorMessage();
        } catch (\Exception $e) {
            $displayMessage = $e->getMessage();
        }
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }
?>