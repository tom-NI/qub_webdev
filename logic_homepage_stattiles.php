<?php
    require("allfunctions.php");
    if (isset($_GET['season_pref'])) {
        $season = $_GET['season_pref'];
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?full_matches&fullseason={$season}";

    } else {
        $currentMaxSeasonInDB = getCurrentSeason();
        $seasonInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?full_matches&fullseason={$currentMaxSeasonInDB}";
    }

    // TODO - get a current list of club names from DB!

    // add all the club names into an array of current season teams
    $allSeasonClubNames = array(
        
    );
    
    // store every stat in an array
    $consistency = array();
    $allGoals = array();
    $allConceded = array();
    $allShots = array();
    $allShotsOT = array();
    $allCorners = array();
    $allFouls = array();
    $allYellowCards = array();
    $allRedCards = array();

    function findMaxAndReturnIndex($arrayToCheck) {
        //Find the highest value in the array
        //by using PHP's max function.
        $maxVal = max($arrayToCheck);

        // search array for max value
        $maxIndex = array_search($maxVal, $arr);
        return $maxIndex;
    }

    // turn all vars into an array

    $lowestConsistencyValue;
    $highestConsistencyValue;
    $lowestConsistencyTeam;
    $highestConsistencyTeam;

    $lowestGoalsValue;
    $highestGoalsValue;
    $lowestGoalsTeam;
    $highestGoalsTeam;

    $lowestConcededValue;
    $highestConcededValue;
    $lowestConcededTeam;
    $highestConcededTeam;

    $lowestShotsValue;
    $highestShotsValue;
    $lowestShotsTeam;
    $highestShotsTeam;

    $lowestShotsOTValue;
    $highestShotsOTValue;
    $lowestShotsOTTeam;
    $highestShotsOTTeam;

    $lowestCornersValue;
    $highestCornersValue;
    $lowestCornersTeam;
    $highestCornersTeam;

    $lowestFoulsValue;
    $highestFoulsValue;
    $lowestFoulsTeam;
    $highestFoulsTeam;

    $lowestYellowCardsValue;
    $highestYellowCardsValue;
    $lowestYellowCardsTeam;
    $highestYellowCardsTeam;

    $lowestRedCardsValue;
    $highestRedCardsValue;
    $lowestRedCardsTeam;
    $highestRedCardsTeam;
    
?>