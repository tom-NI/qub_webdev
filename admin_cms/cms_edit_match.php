<?php
    session_start();
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sending match info to the database after editing!
            if (isset($_GET['finalise_match_edit'])) {
                $noMatchIDisSelected = false;
                include_once(__DIR__ . "/../logic_files/allfunctions.php");
                require(__DIR__ . "/../part_pages/part_post_match.php");
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
                $result = postDevKeyInHeader($endpoint, $matchInfoArray);
                //get the API JSON reply and pull into a var for the users
                if (http_response_code(201)) {
                    $submissionDisplayToUser = "Match Edit Successful";
                } else {
                    $apiJSONReply = json_decode($result, true);
                    $submissionDisplayToUser = $apiJSONReply[0]['reply_message'];
                }
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
                $matchdate = $eachItemName["matchdate"];
                $kickofftime = $eachItemName["kickofftime"];
                $existingRefereeNameToEdit = $eachItemName["refereename"];
                $homeTeamToEdit = $eachItemName["hometeam"];
                $awayTeamToEdit = $eachItemName["awayteam"];
                $hometeamtotalgoals = $eachItemName["hometeamtotalgoals"];
                $hometeamhalftimegoals = $eachItemName["hometeamhalftimegoals"];
                $hometeamshots = $eachItemName["hometeamshots"];
                $hometeamshotsontarget = $eachItemName["hometeamshotsontarget"];
                $hometeamcorners = $eachItemName["hometeamcorners"];
                $hometeamfouls = $eachItemName["hometeamfouls"];
                $hometeamyellowcards = $eachItemName["hometeamyellowcards"];
                $hometeamredcards = $eachItemName["hometeamredcards"];
                $awayteamtotalgoals = $eachItemName["awayteamtotalgoals"];
                $awayteamhalftimegoals = $eachItemName["awayteamhalftimegoals"];
                $awayteamshots = $eachItemName["awayteamshots"];
                $awayteamshotsontarget = $eachItemName["awayteamshotsontarget"];
                $awayteamcorners = $eachItemName["awayteamcorners"];
                $awayteamfouls = $eachItemName["awayteamfouls"];
                $awayteamyellowcards = $eachItemName["awayteamyellowcards"];
                $awayteamredcards = $eachItemName["awayteamredcards"];
            }
        } else {
            // set a message further down the page
            $noMatchIDisSelected = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../stylesheets/mystyles.css">
    <title>Edit a match result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php
        include(__DIR__ . "/../part_pages/part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Edit a match result</h1>
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <?php
                if ($noMatchIDisSelected){
                    echo "<div>
                                <h2 class='title is-size-3 my_info_colour my-4 p-4'>Select a match from the website to edit</h2>
                            </div>
                        </div>
                        </div>
                        </div>";
                        include(__DIR__ . "/../part_pages/part_site_footer.php");
                        
                        echo "<script src='../scripts/my_script.js'></script>
                            <script src='../scripts/my_editmatch_script.js'></script>
                            </body>
                        </html>";
                    die();
                } elseif (isset($_GET['finalise_match_edit'])) {
                    // return message after the user has edited, and give them a link to return to the match page
                    echo "{$submissionDisplayToUser}";
                    echo "<div>
                            <h3 class='title is-size-3 my_info_colour my-4 p-4'>{$submissionDisplayToUser}</h3>
                            <a href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_single_match_result.php?id={$matchToChangeID}'><h4>Return to Match page</h4></a>
                        </div>
                        </div>
                        </div>
                        </div>";
                        include(__DIR__ . "/../part_pages/part_site_footer.php");
                        
                        echo "<script src='../scripts/my_script.js'></script>
                            <script src='../scripts/my_editmatch_script.js'></script>
                            </body>
                        </html>";
                    die();
                }
            ?>

                <!-- edit a matches details form  -->
                <form method="POST" action="cms_edit_match.php?finalise_match_edit">
                    <div class="mt-5 p-5 my_info_colour">
                        <div>
                            <h2 class="title is-size-4 my_info_colour mb-4">Change Match Details:</h2>
                        </div>
                        <div>
                            <div class="my_match_metadata control has-text-right">
                                <label for="match_date" class="my_small_form_item">Match Date:</label>
                            </div>
                            <div class="my_match_metadata">
                                <?php echo"<input type='date' value='{$matchdate}' id='users_match_date_entry'
                                    class='my_small_form_item my-1 input is-info' name='match_date'>"; ?>
                            </div>
                        </div>
                        <div>
                            <div class="my_match_metadata has-text-right">
                                <label for="kick_off_time" class="my_small_form_item">Kick Off Time:</label>
                            </div>
                            <div class="my_match_metadata">
                                <?php echo "<input type='time' value='{$kickofftime}' id='userkickofftime' class='my_small_form_item my-1 input is-info' name='kickoff_time'>"; ?>
                            </div>
                        </div>
                        <div>
                            <div class="my_match_metadata has-text-right">
                                <label for="referee" class="my_small_form_item ">Referee:</label>
                            </div>
                            <div class="my_match_metadata">
                                <div class="select is-info my_small_form_item">
                                    <select class='my_small_form_item' name='select_ref' id='select_ref'>
                                        <?php
                                            require(__DIR__ . "/../part_pages/part_referee_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field p-4 pt-5 mt-5 my_grey_highlight_para">
                        <div class="field">
                            <h2 class="title is-size-4 my_grey_highlight_para">Change Teams:</h2>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <label class="is-size-5 mx-3" id="ht_selector_text" for="ht_selector"><b>Home Team</b></label>
                            <div class="select is-success">
                                <select class='my_small_form_item mx-2 ' name='ht_selector' id='ht_selector'>
                                    <?php
                                        require(__DIR__ . "/../part_pages/part_current_season_team_selector.php");
                                        
                                        // set a control var to make the second select unique (same code used for both <selects>)
                                        $htSelectorIsSet = true;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class='my_inline_divs py-2' id="switch_club_select">
                            <span class="material-icons" id="switch_club_logo">swap_horiz</span>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <div class="select is-danger">
                                <select class='my_small_form_item mx-2' name='at_selector' id='at_selector'>
                                    <?php
                                        require(__DIR__ . "/../part_pages/part_current_season_team_selector.php");
                                    ?>
                                </select>
                            </div>
                            <label class="is-size-5 mx-3" id="at_selector_text" for="at_selector"><b>Away Team</b></label>
                        </div>
                    </div>

                    <!-- entry boxes -->
                    <div class="field ">
                        <div class="field">
                            <h2 class="title is-size-4 mt-6">Change Match statistics:</h2>
                        </div>
                    </div>
                        <?php   
                            require(__DIR__ . "/../part_pages/part_fill_match_edit_form.php");
                        ?>
                    <div class='field'>
                        <h2 class="title is-size-4 mt-6">Justification for data change:</h2>
                        <textarea class='textarea is-info has-fixed-size my-4' minlength="5" maxlength="100"
                            required name="change_justification" id="reason_for_match_edit" cols="100" rows="3" 
                            placeholder="e.g. 'Original Date incorrect' (max 100 characters)."></textarea>
                    </div>
                    <div class="my_grey_highlight_para p-3">
                        <p>I have checked the data for correctness prior to submitting</p>
                        <input required type="radio" id="yes_radio" name="confirmed_accurate"
                            class="control my_inline_divs ml-5 my-3 my_radio_button">
                        <label class="my_inline_divs ml-1 my_radio_button" for="yes_radio">Yes</label>
                        <input checked type="radio" id="no_radio" name="confirmed_accurate"
                            class="control my_inline_divs ml-5 my-3 my_radio_button">
                        <label class="my_inline_divs ml-1 my_radio_button" for="no_radio">No</label>
                    </div>
                    
                    <div class="field is-grouped is-grouped-centered mt-2 mb-4">
                        <button type="reset" id="new_match_reset_button"
                            class="button m-2 is-rounded is-info is-outlined">Reset Form</button>
                        <button type="submit" disabled id="edit_match_submit_button"
                            class="button m-2 is-rounded is-info">Submit Match Edits</button>
                    </div>
                    <div>
                        <input type="hidden" name="id" value="<?php htmlentities(trim($_GET['num'])) ;?>" >
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . "/../part_pages/part_site_footer.php"); ?>
    <script src="../scripts/my_script.js"></script>
    <script src="../scripts/my_editmatch_script.js"></script>

</body>

</html>