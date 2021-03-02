<?php
    // setup session here

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
                <h1 class="title mt-4">Manage Data:</h1>
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <!-- EDIT CLUB AND REFEREE NAMES -->
            <div class="mt-5 p-5 my_info_colour p-3">
                <h2 class="title is-4 mb-2 my_info_colour">Edit Names</h2>
                <p class='my-5'>Caution - changing names will also amend all current records. <br> If existing records are to retain old names, please ADD a new referee or club instead.</p>
                <div class="my-4">
                    <form action="" method="POST" class="level">
                        <div class="select is-info my_medium_form_item">
                            <select required class="level-item my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class='my_medium_textinput_item level-item mx-2'>
                            <input required class="input" type="text" placeholder="New Referee name">
                        </div>
                        <div class='my_medium_form_item level-item'>
                            <button class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Referee Name</button>
                        </div>
                    </form>
                </div>
                <div class="my-4">
                    <form action="" method="POST" class="level">
                        <div class="select is-info my_medium_form_item">
                            <select required class="level-item my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class='my_medium_textinput_item level-item mx-2'>
                            <input required class="input" type="text" placeholder="New Club name">
                        </div>
                        <div class='my_medium_form_item level-item'>
                            <button class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Club Name</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Referees or clubs -->
            <div class="mt-5 p-5 my_info_colour p-3">
                <h2 class="title is-4 mb-2 my_info_colour">Delete Data</h2>
                <p class='my-4'>Data cannot be deleted if it currently forms part of any match record</p>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info level-item">
                            <select required class="my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Club</button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Referee</button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="select_ref" id="edit_ref_select">
                                <?php
                                    require("../part_pages/part_season_select.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Season</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php include("../part_pages/part_site_footer.php"); ?>
    <script src="../scripts/my_script.js"></script>
</body>

</html>