<?php
    // add new data logic only.
    // used only on the add data page.
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $submissionDisplayToUser = "";
        if (isset($_SESSION['userid'])) {
            $userID = $_SESSION['userid'];
        }
        if (isset($_POST['submit_main_match'])) {
            require(__DIR__ . "/logic_files/post_match_logic.php");
            // build the data that has to be sent inside the header, into an assoc array
            $matchInfoArray = http_build_query(
                array(
                    'season' => $seasonName,
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
                    'at_red_cards' => $awayTeamRedCards,
                    'userid' => $userID
                )
            );

            $endpoint ="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_matches/?addnewresult";
            $result = postDevKeyWithData($endpoint, $matchInfoArray);

            //get the API JSON reply and pull into a var for the users
            $apiJSONReply = json_decode($result, true);
            $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
        } elseif (isset($_POST['submit_new_referee'])) {
            $newRefereeName = parseRefereeName(htmlentities(trim($_POST['newrefname'])));
            $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/referees/?addnewref";
            $newRefArray = http_build_query(
                array(
                    'refereename' => $newRefereeName,
                    )
                );
            $result = postDevKeyWithData($endpoint, $newRefArray);

            //get the API JSON reply and pull into a var for the users
            $apiJSONReply = json_decode($result, true);
            $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
        } elseif (isset($_POST['submit_new_season'])) {
            $newSeason = htmlentities(trim($_POST['new_season']));
            $endpoint ="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/seasons/?addnewseason";
            $newSeasonArray = http_build_query(
                array(
                    'newseason' => $newSeason,
                    )
                );
            $result = postDevKeyWithData($endpoint, $newSeasonArray);
            $apiJSONReply = json_decode($result, true);
            $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
        } elseif (isset($_POST['submit_new_club'])) {
            $newClub = htmlentities(trim($_POST['new_club']));
            $newClubURL = htmlentities(trim($_POST['new_club_img_url']));
            $endpoint ="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/clubs/?addnewclub";
            $newClubArray = http_build_query(
                array(
                    'newclubname' => $newClub,
                    'newcluburl' => $newClubURL
                    )
                );
            $result = postDevKeyWithData($endpoint, $newClubArray);
            $apiJSONReply = json_decode($result, true);
            $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
        }
    }
?>