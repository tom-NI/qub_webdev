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
    <?php
        include("part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Add English Premier League Data</h1>
                <p class="subtitle is-5 mt-2">Use this form to add certified Football Association Match Results to our
                    database
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <!-- add new club, ref, season data into db! -->
            <div class="mt-5 p-5 my_info_colour">
                <h2 class="title is-4 my_info_colour">Add new Clubs, Seasons or Referee Names</h2>
                <h2 class="title is-5 mt-5 mb-1 my_info_colour">Add new Referee;</h2>
                <div class="">
                    <p class="p-2">Please enter Referee in the format "First initial. Surname" e.g. A. Referee</p>
                    <form method="POST" action="logic_ref_club_season.php" class="level columns">
                        <input type="text" required id="new_referee" name="newrefname" class="input level-item column is-5 mx-5 is-half-tablet" placeholder="Referee Name">
                        <button class="button level-item is-danger m-3 is-rounded ">Add Referee</button>
                    </form>
                </div>
                <h2 class="title is-5 mt-5 mb-1 my_info_colour">Add new Season;</h2>
                <div class=""> 
                    <p class="p-2">Please enter a season in the format "firstyear-secondyear" with 4 digits for each year e.g. 2000-2001</p>
                    <?php
                        require("allfunctions.php");
                        $suggestedNextSeason = findNextSuggestedSeason();
                        echo "
                        <form method='POST' action='logic_ref_club_season.php' class='level columns'>
                            <input type='text' required id='new_season' name='new_season' class='input level-item column is-5 mx-5 is-half-tablet' placeholder='Suggested next season to add : {$suggestedNextSeason}'>
                            <button class='button level-item is-danger m-3 is-rounded my-3 '>Add New Season</button>
                        </form>";
                    ?>
                </div>
                <h2 class="title is-5 mt-5 mb-1 my_info_colour">Add new Club;</h2>
                <div class="">
                    <p class=" p-1">Please use the official club name and do not abbreviate.  Adding "football club" at the end is not required.</p>
                    <p class="p-1">Club Logo URL must link directly to a .jpg or .png image file</p>
                    <form method="POST" action="logic_ref_club_season.php" class="level columns">
                        <input type="text" required id="new_club" name="new_club" class="input level-item column is-3 mx-2 is-one-third-tablet" maxlength="35" placeholder="Club Name (max 35 Characters)">
                        <input type="url" required id="new_club_img_url" name="new_club_img_url" class="input level-item column is-3 mx-5 is-one-third-tablet" placeholder="Club Logo URL">
                        <button class="button level-item is-danger is-rounded mt-4 my-3 ">Add New Club</button>
                    </form>
                </div>
            </div>

                    <!-- add 1 new match details form  -->
            <div class="field">
                <form method="POST" action="logic_create_match_record.php">
                    <div class="mt-5 p-5 my_info_colour">
                        <div>
                            <h2 class="title is-size-4 my_info_colour">Match Details:</h2>
                        </div>
                        <div class="mt-4">
                            <div class="my_match_metadata has-text-right">
                                    <label for="referee" class="my_small_form_item ">Select Season :</label>
                                </div>
                                <div class="my_match_metadata">
                                    <div class="select is-info my_small_form_item">
                                        <select class='my_small_form_item' name='select_season' id='select_season'>
                                            <?php
                                                require("part_season_select.php");
                                            ?>
                                        </select>
                                    </div>
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
                                    <select class='my_small_form_item' name='select_ref' id='select_ref'>
                                        <?php
                                            require("part_referee_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field p-4 pt-5 mt-5 my_grey_highlight_para">
                        <div class="field">
                            <h2 class="title is-size-4 my_grey_highlight_para">Select Teams:</h2>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <label class="is-size-5 mx-3" id="ht_selector_text" for="ht_selector"><b>Home Team</b></label>
                            <div class="select is-success">
                                <select class='my_small_form_item mx-2 ' name='ht_selector' id='ht_selector'>
                                    <?php
                                        require("part_team_selector.php");
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
                                        require("part_team_selector.php");
                                    ?>
                                </select>
                            </div>
                            <label class="is-size-5 mx-3" id="at_selector_text" for="at_selector"><b>Away Team</b></label>
                        </div>
                    </div>

                    <!-- entry boxes -->
                    <div class="field ">
                        <div class="field">
                            <h2 class="title is-size-4 mt-6">Enter Match statistics:</h2>
                        </div>
                    </div>
                        <?php   
                            // used for placeholder data and minimum entry values
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
                            $homeNameValues = array(
                                "ht_ht_goals",
                                "ht_ft_goals",
                                "ht_total_shots",
                                "ht_shots_on_target",
                                "ht_corners",
                                "ht_total_fouls",
                                "ht_yellow_cards",
                                "ht_red_cards",
                            );
                        
                            $awayNameValues = array(
                                "at_ht_goals",
                                "at_ft_goals",
                                "at_total_shots",
                                "at_shots_on_target",
                                "at_corners",
                                "at_total_fouls",
                                "at_yellow_cards",
                                "at_red_cards",
                            );

                            for ($i = 0; $i < 8; $i++) {
                                echo "<div class='field'>
                                    <p>{$sectionTitles[$i]}</p>
                                    <div class='my_inline_divs m-1 p-1'>
                                        <input required class='my_small_num_entry input is-success' type='number' placeholder='{$zero}'
                                            min='{$zero}' max='{$maxValues[$i]}' id='{$homeNameValues[$i]}' name='{$homeNameValues[$i]}'>
                                    </div>
                                    <div class='my_inline_divs m-1 p-1'>
                                        <input class='my_small_num_entry input is-danger' type='number' required placeholder='{$zero}'
                                            min='{$zero}' max='{$maxValues[$i]}' id='{$awayNameValues[$i]}' name='{$awayNameValues[$i]}'>
                                    </div>
                                </div>";
                            }
                        ?>
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