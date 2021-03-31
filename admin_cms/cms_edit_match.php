<?php
    session_start();
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    require(__DIR__ . "/../logic_files/edit_match_logic.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once(__DIR__ . "/../part_pages/all_page_dependencies.php"); ?>
    <title>Edit a match result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php
        // Full nav bar
        include(__DIR__ . "/../part_pages/part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">Edit a match result</h1>
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
                            <h2 class="title is-size-4 my_info_colour mb-4 is-size-5-mobile">Change Match Details:</h2>
                        </div>
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="match_date" class="my_small_form_item">Match Date:</label>
                            </div>
                            <div class="column is-6 has-text-left">
                                <?php echo"<input type='date' value='{$matchdate}' id='users_match_date_entry'
                                    class='my_small_form_item my-1 input is-info' name='match_date'>"; ?>
                            </div>
                        </div> 
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="kick_off_time" class="my_small_form_item">Kick Off Time:</label>
                            </div>
                            <div class="column is-6 has-text-left">
                                <?php echo "<input type='time' value='{$kickofftime}' id='userkickofftime' class='my_small_form_item my-1 input is-info' name='kickoff_time'>"; ?>
                            </div>
                        </div>
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-6 has-text-right">
                                <label for="referee" class="my_small_form_item ">Referee:</label>
                            </div>
                            <div class="column is-6 has-text-left">
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
                            <h2 class="title is-size-4 my_grey_highlight_para is-size-5-mobile">Change Teams:</h2>
                        </div>
                        <div class="my_inline_divs m-1 mt-4">
                            <label class="is-size-5 mx-3 is-size-6-mobile" id="ht_selector_text" for="ht_selector"><b>Home Team</b></label>
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
                            <label class="is-size-5 mx-3 is-size-6-mobile" id="at_selector_text" for="at_selector"><b>Away Team</b></label>
                        </div>
                    </div>

                    <!-- entry boxes -->
                    <div class="field ">
                        <div class="field">
                            <h2 class="title is-size-4 mt-6 is-size-5-mobile">Change Match statistics:</h2>
                        </div>
                    </div>
                        <?php   
                            require(__DIR__ . "/../part_pages/part_fill_match_edit_form.php");
                        ?>
                    <div class='field'>
                        <h2 class="title is-size-4 mt-6 is-size-5-mobile">Justification for data change:</h2>
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
                        <button type="reset" id="new_match_reset_button" class="button m-2 is-rounded is-info is-outlined">Reset Form</button>
                        <button type="submit" disabled id="new_match_submit_button" class="button m-2 is-rounded is-info">
                            <span class="material-icons">send</span>
                            <span class="ml-2 ">Submit Edits</span>
                        </button>
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