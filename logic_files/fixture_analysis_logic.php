<?php
    if (isset($_GET['ht_selector']) && isset($_GET['at_selector']) 
    && $_GET['ht_selector'] != "Select Team" && $_GET['at_selector'] != "Select Team") {
    include_once(__DIR__ . "/logic_files/allfunctions.php");
    // both these unfiltered vars only use for website display
    $teamA = removeUnderScores($_GET['ht_selector']);
    $teamB = removeUnderScores($_GET['at_selector']);
    $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$teamA}</b></h4>";
    $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-left team_b_name_colour'><b>{$teamB}</b></h4>";

    $finalHomeTeamurl = addUnderScores(htmlentities(trim($teamA)));
    $finalAwayTeamurl = addUnderScores(htmlentities(trim($teamB)));

    // switch the API request based on whether user wants fixture matching or not
    if (isset($_GET['strict'])) {
    $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}";
    $strictPara = "Data includes reverse fixture";
    } else {
    $fixtureAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?fixture={$finalHomeTeamurl}~{$finalAwayTeamurl}&strict";
    $strictPara = "Data does NOT include reverse fixture";
    }
    $fixtureAPIdata = postDevKeyInHeader($fixtureAPIurl);
    $fixtureList = json_decode($fixtureAPIdata, true);

    // import huge logic file to read every fixture
    require(__DIR__ . "/logic_files/fixture_analysis.php");
    }
?>