<?php
    // session_start();
    // if (!isset($_SESSION['site_admin'])) {
    //     header("Location: login.php");
    // }

    // get all the info from a particular match
    $matchID = $_GET['id'];
    $matchInfoURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/full_match?onematch={$matchID}";
    require("../part_pages/api_auth.php");
    $matchData = file_get_contents($matchInfoURL, false, $context);
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
        include("../part_pages/part_site_navbar.php"); 
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
            <!-- edit a matches details form  -->
            <div class="field">
                <form method="POST" action="logic_create_match_record.php">
                    <div class="mt-5 p-5 my_info_colour">
                        <div>
                            <h2 class="title is-size-4 my_info_colour">Change Match Details:</h2>
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
                                            require("../part_pages/part_referee_selector.php");
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
                                        require("../part_pages/part_team_selector.php");
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
                                        require("../part_pages/part_team_selector.php");
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
                            // used for placeholder data and minimum entry values
                            // loop to create all the input fields from preset arrays
                            $zero = 0;

                            $sectionTitles = array(
                                "Half Time Goals:",
                                "Full Time Goals:",
                                "Total Shots:",
                                "Shots on Target:",
                                "Corners:",
                                "Total Fouls:",
                                "Yellow Cards:",
                                "Red Cards:"
                            );
                        
                            $maxValues = array(
                                50,
                                50,
                                50,
                                50,
                                200,
                                100,
                                22,
                                5
                            );
                            $homeNameIDs = array(
                                "ht_ht_goals",
                                "ht_ft_goals",
                                "ht_total_shots",
                                "ht_shots_on_target",
                                "ht_corners",
                                "ht_total_fouls",
                                "ht_yellow_cards",
                                "ht_red_cards",
                            );

                            $awayNameIDs = array(
                                "at_ht_goals",
                                "at_ft_goals",
                                "at_total_shots",
                                "at_shots_on_target",
                                "at_corners",
                                "at_total_fouls",
                                "at_yellow_cards",
                                "at_red_cards",
                            );

                            $homeValues = array(
                                $hometeamtotalgoals,
                                $hometeamhalftimegoals,
                                $hometeamshots,
                                $hometeamshotsontarget,
                                $hometeamcorners,
                                $hometeamfouls,
                                $hometeamyellowcards,
                                $hometeamredcards
                            );

                            $awayValues = array(
                                $awayteamtotalgoals,
                                $awayteamhalftimegoals,
                                $awayteamshots,
                                $awayteamshotsontarget,
                                $awayteamcorners,
                                $awayteamfouls,
                                $awayteamyellowcards,
                                $awayteamredcards
                            );

                            for ($i = 0; $i < 8; $i++) {
                                echo "<div class='field'>
                                    <p>{$sectionTitles[$i]}</p>
                                    <div class='my_inline_divs m-1 p-1'>
                                        <input required class='my_small_num_entry input is-success' type='number' placeholder='{$zero}'
                                            min='{$zero}' max='{$maxValues[$i]}' value='{$homeValues[$i]}' id='{$homeNameIDs[$i]}' name='{$homeNameIDs[$i]}'>
                                    </div>
                                    <div class='my_inline_divs m-1 p-1'>
                                        <input class='my_small_num_entry input is-danger' type='number' required placeholder='{$zero}'
                                            min='{$zero}' max='{$maxValues[$i]}' value='{$awayValues[$i]}' id='{$awayNameIDs[$i]}' name='{$awayNameIDs[$i]}'>
                                    </div>
                                </div>";
                            }
                        ?>
                    <div class='field'>
                        <textarea class='textarea is-info has-fixed-size my-4' minlength="5" maxlength="100" 
                            required name="reason_for_match_edit" id="reason_for_match_edit" cols="100" rows="3" 
                            placeholder="Justification for change (100 characters max). &#13; for example: 'Data originally entered incorrectly'"></textarea>
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
                        <button type="submit" disabled id="new_match_submit_button"
                            class="button m-2 is-rounded is-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("../part_pages/part_site_footer.php"); ?>
    <script src="../scripts/my_script.js"></script>
    <script src="../scripts/my_editmatch_script.js"></script>

</body>

</html>