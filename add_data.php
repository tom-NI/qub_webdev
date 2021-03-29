<?php
    session_start();
    include_once(__DIR__ . "/logic_files/allfunctions.php");
    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } else {
        require(__DIR__ . "/logic_files/add_data_page_logic.php");
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
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <title>Add data</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php
        include(__DIR__ . "/part_pages/part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">Add English Premier League Data</h1>
                <p class="subtitle is-5 mt-2 is-size-6-mobile">Use this form to add data to our database</p>
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <?php 
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo "<div class='mt-5 p-5 has-background-warning'>
                        <div>
                            <h3 class='title is-5'>{$submissionDisplayToUser}</h3>
                            <p class='subtitle is-6 pt-3'>Please add further data below</p>
                        </div>
                    </div>";
                }


                if (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] === "admin") {
                    // only display the addition of referees, clubs and seasons to admins.
                    // general website users (joe public) can add matches
                    
                    $suggestedNextSeason = findNextSuggestedSeason();
                    echo "
                    <!-- add new club, ref, season data into db! -->
                    <div class='mt-5 p-5 my_info_colour'>
                        <h2 class='title is-4 my_info_colour is-size-5-mobile'>Add new Clubs, Seasons or Referee Names</h2>
                        <h3 class='title is-5 mt-5 mb-1 my_info_colour is-size-6-mobile'>Add new Referee;</h3>
                        <div class=''>
                            <p class='p-2 is-size-7-mobile'>Please enter Referee's first and last name, with a space between e.g. New Referee</p>
                            <form method='POST' action='add_data.php' class='level columns'>
                                <input type='text' required id='new_referee' name='newrefname' minlength='4' maxlength='30' class='input level-item column is-5 my-3 is-half-tablet' placeholder='Referee Name'>
                                <div class='my_medium_form_item'>
                                    <button class='button level-item my_medium_form_item is-danger m-3 is-rounded is-pulled-right' name='submit_new_referee'>
                                        <span class='icon'>
                                            <i class='fas fa-plus'></i>
                                        </span>
                                        <span>Add Referee</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <h3 class='title is-5 mt-5 mb-1 my_info_colour is-size-6-mobile'>Add new Season;</h3>
                        <div class=''> 
                            <p class='p-2 is-size-7-mobile'>Please enter a season in the format 'firstyear-secondyear' with 4 digits for each year e.g. 2000-2001</p>
                                <form method='POST' action='add_data.php' class='level columns'>
                                    <input type='text' required id='new_season' name='new_season' class='input level-item column is-5 my-3 is-half-tablet' placeholder='Suggested next season to add : {$suggestedNextSeason}'>
                                    <div class='my_medium_form_item'>
                                        <button class='button level-item my_medium_form_item is-danger m-3 is-rounded my-3 is-pulled-right' name='submit_new_season'>
                                            <span class='icon'>
                                                <i class='fas fa-plus'></i>
                                            </span>
                                            <span>Add New Season</span>
                                        </button>
                                    </div>
                                </form>
                        </div>
                        <h3 class='title is-5 mt-5 mb-1 my_info_colour is-size-6-mobile'>Add new Club;</h3>
                        <div class=''>
                            <p class='p-1 is-size-7-mobile'>Please use the official club name and do not abbreviate.  Maximum 2 words.</p>
                            <p class='p-1 is-size-7-mobile mb-3'>Club Logo URL must link directly to a .jpg or .png image file</p>
                            <form method='POST' action='add_data.php' class='level columns'>
                                <input type='text' required id='new_club' name='new_club' class='input level-item column is-3 my-3 is-one-third-tablet' maxlength='35' placeholder='Club Name (max 35 Characters)'>
                                <input type='url' required id='new_club_img_url' name='new_club_img_url' class='input level-item column is-3 my-2 is-one-third-tablet' placeholder='Club Logo URL'>
                                <button class='button level-item is-danger is-rounded mt-4 m-3 is-pulled-right' name='submit_new_club'>
                                    <span class='icon'>
                                        <i class='fas fa-plus'></i>
                                    </span>
                                    <span>Add New Club</span>
                                </button>
                            </form>
                        </div>
                    </div>";
                } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] === "user") {
                    // if a user is signed in, show the bar allowing them to email a referee change request to admins
                    echo"
                        <div class='mt-5 p-3 my_info_colour '>
                            <div><h3 class='title is-4 p-4 my_info_colour is-size-5-mobile'>Request a new Season, Club or Referee</h3></div>
                            <div class='level'>
                                <a href='mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - Referee Change Request &body=Dear Admin, Could the following referee be add/removed from the database as they no longer officiate at Premier League Matches, Many thanks'>
                                    <button class='level-item button is-danger m-3 is-rounded ml-3'>
                                    <span class='material-icons'>sports</span>
                                    <span class='ml-3'>Request Referee Changes</span>
                                    </button>
                                </a>
                                <a href='mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - New Season Request &body=Dear Admin, Can a new Season be added to the statfinder website so new season match results can be added, Many thanks'>
                                    <button class='level-item button is-danger m-3 is-rounded my-3'>
                                    <span>
                                        <i class='far fa-calendar-alt'></i>
                                    </span>
                                    <span class='ml-3'>Request New Season</span>
                                    </button>
                                </a>
                                <a href='mailto:tkilpatrick01@qub.ac.uk?subject=StatFinder Website - Club Change Request &body=Dear Admin, Can i request the following club to be added/removed from the site club listing as they have been promoted/relegated from the Premier League, Many thanks'>
                                    <button class='mr-5 level-item button is-danger m-3 is-rounded my-3'>
                                    <span>
                                        <i class='far fa-futbol'></i>
                                    </span>
                                    <span class='ml-3'>Request Club Changes</span>
                                    </button>
                                </a>
                            </div>
                        </div>";  
                }
            ?>

            <!-- add 1 new match details form  -->
            <div class="field">
                <form method="POST" action='add_data.php'>
                    <div class="mt-5 p-5 my_info_colour">
                        <div>
                            <h2 class="title is-4 my_info_colour is-size-5-mobile">Add a new match result:</h2>
                            <h3 class="title is-size-5 my_info_colour is-size-6-mobile">Match Details:</h3>
                        </div>
                        <div class="mt-4">
                            <div class="my_match_metadata ">
                                <?php
                                    // dynamically set the correct current season on the UI
                                    $currentSeason = getCurrentSeason();
                                    echo "<p class='mb-4 subtitle is-6 my_info_colour'>Current Season : {$currentSeason}</p>";
                                ?>
                            </div>
                        </div>
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="match_date" class="my_small_form_item">Match Date :</label>
                            </div>
                            <div class="column is-6 has-text-left">
                                <input type="date" id="users_match_date_entry" class="my_small_form_item my-1 input is-info " name="match_date">
                            </div>
                        </div>
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="kickoff_time" class="my_small_form_item">Kick Off Time :</label>
                            </div>
                            <div class="column is-6 has-text-left">
                                <input type="time" class="my_small_form_item my-1 input is-info" id='kickoff_time' name="kickoff_time">
                            </div>
                        </div>
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="select_ref" class="my_small_form_item ">Referee :</label>
                            </div>
                            <div class="column is-6 has-text-left">
                                <div class="select is-info my_small_form_item">
                                    <select required class='my_small_form_item' name='select_ref' id='select_ref'>
                                        <?php
                                            require(__DIR__ . "/part_pages/part_referee_selector.php");
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field p-4 pt-5 mt-5 my_grey_highlight_para">
                        <div class="field">
                            <h2 class="title is-size-4 is-size-5-mobile my_grey_highlight_para">Select Teams:</h2>
                        </div>
                        <div class="level">
                            <div class="my_inline_divs m-1 mt-4">
                                <label class="is-size-5 mx-3 level-item is-size-6-mobile" id="ht_selector_text" for="ht_selector"><b>Home Team</b></label>
                                <div class="select is-success level-item">
                                    <select required class='my_small_form_item mx-2 ' name='ht_selector' id='ht_selector'>
                                        <?php
                                            require(__DIR__ . "/part_pages/part_current_season_team_selector.php");
                                            // control var for the second team <select> to ensure its unique
                                            $htSelectorIsSet = true;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class='my_inline_divs py-2' id="switch_club_select">
                                <span class="material-icons level-item" id="switch_club_logo">swap_horiz</span>
                            </div>
                            <div class="my_inline_divs m-1 mt-4">
                                <div class="select is-danger level-item">
                                    <select required class='my_small_form_item mx-2' name='at_selector' id='at_selector'>
                                        <?php
                                            require(__DIR__ . "/part_pages/part_current_season_team_selector.php");
                                        ?>
                                    </select>
                                </div>
                                <label class="is-size-5 mx-3 level-item is-size-6-mobile" id="at_selector_text" for="at_selector"><b>Away Team</b></label>
                            </div>
                        </div>
                    </div>

                    <!-- entry boxes -->
                    <div class="field ">
                        <div class="field">
                            <h2 class="title is-size-4 mt-6 is-size-5-mobile">Enter the new Match statistics:</h2>
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
                        <!-- confirm accurate data panel -->
                    <div class="my_grey_highlight_para p-3">
                        <p>I have checked this match data is accurate prior to submitting</p>
                        <input required type="radio" id="yes_radio" name="confirmed_accurate"
                            class="control my_inline_divs ml-5 my-3 my_radio_button">
                        <label class="my_inline_divs ml-1 my_radio_button" for="yes_radio">Yes</label>
                        <input checked type="radio" id="no_radio" name="confirmed_accurate"
                            class="control my_inline_divs ml-5 my-3 my_radio_button">
                        <label class="my_inline_divs ml-1 my_radio_button" for="no_radio">No</label>
                    </div>

                    <!-- reset / submit button panel -->
                    <div class="columns is-mobile is-vcentered mt-2 mb-4">
                        <div class="column is-6 has-text-right mr-1">
                            <button type="reset" id="new_match_reset_button" class="button is-rounded is-info is-outlined">Reset Form</button>
                        </div>
                        <div class="column is-6 has-text-left ml-1">
                            <button type="submit" disabled name='submit_main_match' id="new_match_submit_button"
                                class="button mx-1 is-rounded is-info">
                                    <span class="material-icons">send</span>
                                    <span class='ml-3'>Submit</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include(__DIR__ . "/part_pages/part_site_footer.php"); ?>
    <script src="scripts/my_script.js"></script>
</body>

</html>