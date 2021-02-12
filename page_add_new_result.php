<?php
    include("dbconn.php");

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyles.css">
    <title>Upload match result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php include("part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Add a Match Result</h1>
                <p class="subtitle is-5 mt-2">Use this form to add certified Football Association Match Results to our
                    database
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <div class="field">
                <form action="POST">
                    <div class="mt-5 p-5 my_info_colour">
                        <div>
                            <h2 class="title is-size-4 my_info_colour">Match Details:</h2>
                        </div>
                        <div class="mt-4">
                            <div class="my_match_metadata has-text-right">
                                <p class="my_small_form_item">Current Season : 2020-2021</p>
                            </div>

                        </div>
                        <div>
                            <div class="my_match_metadata control has-text-right">
                                <label for="match_date" class="my_small_form_item">Match Date:</label>
                            </div>
                            <div class="my_match_metadata">
                                <input type="date" id="users_match_date_entry"
                                    class="my_small_form_item my-1 input is-info" name="match_date">
                            </div>
                        </div>
                        <div>
                            <div class="my_match_metadata has-text-right">
                                <label for="kick_off_time" class="my_small_form_item">Kick Off Time:</label>
                            </div>
                            <div class="my_match_metadata">
                                <input type="time" class="my_small_form_item my-1 input is-info" name="kickoff_time">
                            </div>
                        </div>
                        <div>
                            <div class="my_match_metadata has-text-right">
                                <label for="referee" class="my_small_form_item ">Referee:</label>
                            </div>
                            <div class="my_match_metadata">
                                <div class="select is-info my_small_form_item">
                                    <?php
                                        echo "<select class='my_small_form_item' name='select_ref' id='select_ref'>";
                                        $refereeResult=$conn->query($refereeNameQuery);
                                        while ($row = $refereeResult->fetch_assoc()) {
                                            echo "<option value='{$row["RefereeName"]}'>{$row["RefereeName"]}</option>";
                                        }
                                        echo "</select>";
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="mt-5">If the season needs to be changed, or the list of referees does not contain
                                the relevent referee, please submit a request to have the lists updated below</p>
                            <div class="my_inline_divs">
                                <a
                                    href="mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - Referee Change Request &body=Dear Admin, Could the following referee be add/removed from the database as they now officiate / no longer officiate at Premier League Matches, Many thanks">
                                    <button class="button is-danger m-3 is-rounded">Referee
                                        Change Request</button>
                                </a>
                                <a
                                    href="mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - New Season Request &body=Dear Admin, Can a new Season be added to the statfinder website so new season match results can be added, Many thanks">
                                    <button class="button is-danger m-3 is-rounded my-3">Request
                                        New Season</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="field p-4 pt-5 mt-5 my_grey_highlight_para">
                        <div class="field">
                            <h2 class="title is-size-4 my_grey_highlight_para">Select Teams:</h2>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <label class="is-size-5 mx-3" id="ht_selector_text" for="ht_selector"><b>Home
                                    Team</b></label>
                            <div class="select is-success">
                                <select class='my_small_form_item mx-2 ' name='ht_selector' id='ht_selector'>
                                    <?php
                                        require("part_team_selector");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <div class="select is-danger">
                                <select class='my_small_form_item mx-2' name='at_selector' id='at_selector'>
                                    <?php
                                        require("part_team_selector");
                                    ?>
                                </select>
                            </div>
                            <label class="is-size-5 mx-3" id="at_selector_text" for="at_selector"><b>Away
                                    Team</b></label>
                        </div>
                        <div>
                            <p class="mt-4">If a current Premier League club is not listed for match entry, please
                                request a club change below:
                            </p>
                            <a
                                href="mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - Club Change Request &body=Dear Admin, Can i request the following club to be added/removed from the site club listing as they have been promoted/relegated from the Premier League, Many thanks">
                                <button class="button is-danger is-rounded mt-4 mb-3">Request
                                    Club Change</button>
                            </a>
                        </div>
                    </div>

                    <!-- entry boxes -->
                    <div class="field ">
                        <div class="field">
                            <h2 class="title is-size-4 mt-6">Enter Match statistics:</h2>
                        </div>
                    </div>
                    <div class="field">
                        <p>Half Time Goals:</p>
                        <div class="my_inline_divs m-1 p-1">
                            <input required class="my_small_num_entry input is-success" type="number" placeholder="0"
                                min="0" max="50" id="ht_half_time_goals" name="ht_ht_goals">
                        </div>
                        <div class="my_inline_divs m-1 p-1">
                            <input class="my_small_num_entry input is-danger" type="number" required placeholder="0"
                                min="0" max="50" id="at_half_time_goals" name="at_ht_goals">
                        </div>
                    </div>
                    <div class="field">
                        <p>Full Time Goals:</p>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-success" required placeholder="0"
                                min="0" max="50" id="ht_full_time_goals" name="ht_ft_goals">
                        </div>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                min="0" max="50" id="at_full_time_goals" name="at_ft_goals">
                        </div>
                    </div>
                    <div class="field">
                        <p>Total Shots:</p>
                        <div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-success" required
                                    placeholder="0" min="0" max="50" id="ht_total_shots" name="ht_total_shots">
                            </div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                    min="0" max="50" name="at_total_shots" id="at_total_shots">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <p>Shots on Target:</p>
                        <div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-success" required
                                    placeholder="0" min="0" max="50" id="ht_shots_on_target" name="ht_shots_on_target">
                            </div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                    min="0" max="50" id="at_shots_on_target" name="at_shots_on_target">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <p>Corners:</p>
                        <div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-success" required
                                    placeholder="0" min="0" max="200" id="ht_corners" name="ht_corners">
                            </div>
                            <div class="my_inline_divs m-1 p-1">
                                <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                    min="0" max="200" id="at_corners" name="at_corners">
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <p>Total Fouls:</p>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-success" required placeholder="0"
                                min="0" max="100" name="ht_total_fouls" id="ht_total_fouls">
                        </div>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                min="0" max="100" name="at_total_fouls" id="at_total_fouls">
                        </div>
                    </div>
                    <div class="field">
                        <p>Yellow Cards:</p>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-success" required placeholder="0"
                                min="0" max="22" name="" id="ht_yellow_cards" name="ht_yellow_cards">
                        </div>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                min="0" max="22" name="" id="at_yellow_cards" name="at_yellow_cards">
                        </div>
                    </div>
                    <div class="field">
                        <p>Red Cards:</p>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-success" required placeholder="0"
                                min="0" max="5" name="" id="ht_red_cards" name="ht_red_cards">
                        </div>
                        <div class="my_inline_divs m-1 p-1">
                            <input type="number" class="my_small_num_entry input is-danger" required placeholder="0"
                                min="0" max="5" name="" id="at_red_cards" name="at_red_cards">
                        </div>
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

    <?php include("part_site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>