<?php
    session_start();
    include_once(__DIR__ . "/../logic_files/manage_data_logic.php");
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
        <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<div class='mt-5 p-5 has-background-warning'>
                    <div>
                        <h3 class='title is-5'>{$submissionDisplayToUser}</h3>
                        <p class='subtitle is-6 pt-3'>Please modify further data below.</p>
                    </div>
                </div>";
            }
        ?>
        <!--  -->
        <div class="mt-5 p-5 my_info_colour p-3">
            <h2 class="title is-4 mb-2 my_info_colour">Edit or Delete a Match</h2>
            <p class='mx-6 px-6'>Select any individual match from the Home Page or Match Search, then select edit or delete from the administration panel on the match detail page</p>
        </div>

        <!-- EDIT CLUB AND REFEREE NAMES -->
        <div class="mt-5 p-5 my_info_colour p-3">
            <h2 class="title is-4 mb-2 my_info_colour">Edit Names</h2>
            <p>Editing Names will only impact data added in future, not historic results.</p>
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
                        <input required class="input" type="text" name="new_ref_name" placeholder="New Referee name">
                    </div>
                    <div class='my_medium_form_item level-item'>
                        <button name="change_ref" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>
                            <span class='icon has-text-left'>
                                <i class="fas fa-pen"></i>
                            </span>
                            <span>Change Referee Name</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="my-4">
                <form action="" method="POST" class="level">
                    <div class="select is-info my_medium_form_item">
                        <select required class="level-item my_medium_form_item" name="select_club" id="edit_club_select">
                            <?php
                                require("../part_pages/part_allteams_selector.php");
                            ?>
                        </select>
                    </div>
                    <div class='my_medium_textinput_item level-item mx-2'>
                        <input required class="input" type="text" name="new_club_name" placeholder="New Club name">
                    </div>
                    <div class='my_medium_form_item level-item'>
                        <button name="change_club" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>
                            <span class='icon has-text-left'>
                                <i class="fas fa-pen"></i>
                            </span>
                            <span>Change Club Name</span>
                        </button>
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
                            <select required class="my_medium_form_item" name="select_delete_club" id="delete_club_select">
                                <?php
                                    require("../part_pages/part_allteams_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_club" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>
                                <span class='icon has-text-left'>
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span>Delete Club</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="select_delete_ref" id="delete_ref_select">
                                <?php
                                    require("../part_pages/part_referee_selector.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_ref" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>
                                <span class='icon has-text-left'>
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span>Delete Referee</span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class='my-4 level-item'>
                    <form action="" method="POST" class="level">
                        <div class="select is-info ">
                            <select required class="my_medium_form_item" name="delete_season_select" id="delete_season_select">
                                <?php
                                    require("../part_pages/part_season_select.php");
                                ?>
                            </select>
                        </div>
                        <div class=''>
                            <button name="delete_season" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>
                                <span class='icon has-text-left'>
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span>Delete Season</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- add a new site administrator -->
            <div class="my_grey_highlight_para p-3 mt-6">
                    <div class="column is-6 is-offset-3">
                    <!-- registration section -->
                    <div class="mt-3">
                        <h2 class='title is-4 pt-4'>Add a new Administrator</h2>
                        <p class='mt-2 has-text-left'>* Required</p>
                        <form class="form control" 
                        action="" method="POST">
                            <div>
                                <label class="label mt-3 has-text-left" for="">* Admin First Name :</label>
                                <div class='control'>
                                    <input class="input" required name="admin_register_firstname" type="text" minlength="3" maxlength="15">
                                </div>
                            </div>
                            <div>
                                <label class="label mt-3 has-text-left" for="">* Admin Surname :</label>
                                <div class='control'>
                                    <input class="input" required name="admin_register_surname" type="text" minlength="3" maxlength="15">
                                </div>
                            </div>
                            <div>
                                <label class="label mt-3 has-text-left" for="">* Admin Email address :</label>
                                <div class='control'>
                                    <input class="input" required name="admin_register_email" type="email">
                                </div>
                            </div>
                            <div>
                                <label class="label mt-3 has-text-left" for="">* Admin temporary Password :</label>
                                <div class='control'>
                                    <input class="input " required name="admin_register_pw1" minlength='8' type="password" placeholder="Enter admin temporary password here">
                                </div>
                                <label class="label mt-3 has-text-left" for="">* Please reenter temporary password :</label>
                                <div class='control'>
                                    <input class="input" required name="admin_register_pw2" minlength='8' type="password" placeholder="Reenter password here">
                                </div>
                            </div>
                            <div>
                                <button class="button is-danger m-4" name="create_new_admin_btn">Create New Admin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include("../part_pages/part_site_footer.php"); ?>
    <script src="../scripts/my_script.js"></script>
</body>

</html>