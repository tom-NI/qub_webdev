<?php
    include_once(__DIR__ . "/allfunctions.php");

    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // sending match info to the database after editing!
            if (isset($_GET['finalise_match_edit'])) {
                $noMatchIDisSelected = false;
                
                // build each form parameter into a variable
                require(__DIR__ . "/post_match_logic.php");
                $matchToChangeID = htmlentities(trim($_POST['id']));
                
                $justForChange = htmlentities(trim($_POST['change_justification']));
                
                // build the data that has to be sent inside the header, into an assoc array
                $matchInfoArray = http_build_query(
                    array(
                        'id' => $matchToChangeID,
                        'change_justification' => $justForChange,
                        'date' => $matchDate,
                        'time' => $kickOffTime,
                        'referee_name' => $refereeName,
                        'home_club' => $homeClubName,
                        'away_club' => $awayClubName,
                        'ht_total_goals' => $homeTeamTotalGoals,
                        'ht_half_time_goals' => $homeTeamHalfTimeGoals,
                        'ht_shots' => $homeTeamShots,
                        'ht_shots_on_target' => $homeTeamShotsOnTarget,
                        'ht_corners' => $homeTeamCorners,
                        'ht_fouls' => $homeTeamFouls,
                        'ht_yellow_cards' => $homeTeamYellowCards,
                        'ht_red_cards' => $homeTeamRedCards,
                        'at_total_goals' => $awayTeamTotalGoals,
                        'at_half_time_goals' => $awayTeamHalfTimeGoals,
                        'at_shots' => $awayTeamShots,
                        'at_shots_on_target' => $awayTeamShotsOnTarget,
                        'at_corners' => $awayTeamCorners,
                        'at_fouls' => $awayTeamFouls,
                        'at_yellow_cards' => $awayTeamYellowCards,
                        'at_red_cards' => $awayTeamRedCards
                    )
                );

                $endpoint ="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches/?editmatch";
                $result = postDevKeyWithData($endpoint, $matchInfoArray);
                print_r($result);
                
                //get the API JSON reply and pull into a var for the users
                $apiJSONReply = json_decode($result, true);
                $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
                print_r($submissionDisplayToUser);
            }
        } elseif (isset($_GET['num'])) {
            // user is editing the match, so get all the data from the matchID and populate the form
            $noMatchIDisSelected = false;
            // GET AND DISPLAY ALL THE INFORMATION INTO THE FORM FOR THE USER TO EDIT`
            // get all the info from a particular match and load it into the form!
            $matchID = htmlentities(trim($_GET['num']));
            $matchInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches?onematch={$matchID}";
            $matchData = postDevKeyInHeader($matchInfoURL);
            $matchList = json_decode($matchData, true);
        
            foreach ($matchList as $eachItemName) {
                $matchdate = $eachItemName["match_date"];
                $kickofftime = $eachItemName["kick_off_time"];
                $existingRefereeNameToEdit = $eachItemName["referee_name"];
                $homeTeamToEdit = $eachItemName["home_team"];
                $awayTeamToEdit = $eachItemName["away_team"];
                $hometeamtotalgoals = $eachItemName["home_team_total_goals"];
                $hometeamhalftimegoals = $eachItemName["home_team_half_time_goals"];
                $hometeamshots = $eachItemName["home_team_shots"];
                $hometeamshotsontarget = $eachItemName["home_team_shots_on_target"];
                $hometeamcorners = $eachItemName["home_team_corners"];
                $hometeamfouls = $eachItemName["home_team_fouls"];
                $hometeamyellowcards = $eachItemName["home_team_yellow_cards"];
                $hometeamredcards = $eachItemName["home_team_red_cards"];
                $awayteamtotalgoals = $eachItemName["away_team_total_goals"];
                $awayteamhalftimegoals = $eachItemName["away_team_half_time_goals"];
                $awayteamshots = $eachItemName["away_team_shots"];
                $awayteamshotsontarget = $eachItemName["away_team_shots_on_target"];
                $awayteamcorners = $eachItemName["away_team_corners"];
                $awayteamfouls = $eachItemName["away_team_fouls"];
                $awayteamyellowcards = $eachItemName["away_team_yellow_cards"];
                $awayteamredcards = $eachItemName["away_team_red_cards"];
            }
        } else {
            // set a message further down the page
            $noMatchIDisSelected = true;
        }
    }
?>