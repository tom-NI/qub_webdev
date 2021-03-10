<?php
    session_start();
    if (!isset($_SESSION['sessiontype']) || strlen($_SESSION['sessiontype']) == 0) {
        header("Location: login.php");
    } elseif (isset($_SESSION['sessiontype']) && $_SESSION['sessiontype'] == "admin") {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            require("../logic_files/allfunctions.php");
            if (isset($_POST['change_ref'])) {
                $refereeToChange = htmlentities(trim($_POST['select_ref']));
                $newRefereeName = htmlentities(trim($_POST['new_ref_name']));
                $dataToSend = http_build_query(
                    array(
                        'ref_to_change' => $refereeToChange,
                        'new_ref_name' => $newRefereeName
                    )
                );
                // $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?edit";
                $apiReply = postDataInHeader($endpoint, $dataToSend);

                // decode reply from API
                // $apiJSON = json_decode($apiReply, true);
                // $reply = $row[0]["reply_message"];

            } elseif (isset($_POST['change_club'])) {
                $clubToChange = htmlentities(trim($_POST['select_club']));
                $newClubName = htmlentities(trim($_POST['new_club_name']));
                $dataToSend = http_build_query(
                    array(
                        'club_to_change' => $clubToChange,
                        'new_club_name' => $newClubName
                    )
                );
                // $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?edit";
                $apiReply = postDataInHeader($endpoint, $dataToSend);

            } elseif (isset($_POST['delete_club'])) {
                $clubToDelete = htmlentities(trim($_POST['select_delete_club']));
                $dataToSend = http_build_query(
                    array(
                        'deleted_club' => $clubToDelete
                    )
                );
                // $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?delete";
                $apiReply = postDataInHeader($endpoint, $dataToSend);
            } elseif (isset($_POST['delete_ref'])) {
                $refereeToDelete = htmlentities(trim($_POST['select_delete_ref']));
                $dataToSend = http_build_query(
                    array(
                        'deleted_referee' => $refereeToDelete
                    )
                );
                // $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?delete";
                $apiReply = postDataInHeader($endpoint, $dataToSend);
            } elseif (isset($_POST['delete_season'])) {
                $seasonToDelete = htmlentities(trim($_POST['delete_season_select']));
                $dataToSend = http_build_query(
                    array(
                        'deleted_season' => $seasonToDelete
                    )
                );
                // $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?delete";
                $apiReply = postDataInHeader($endpoint, $dataToSend);
            } else {
                echo "unknown Request";
            }
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
        include("../part_pages/part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Manage Data:</h1>
                <?php 
                    $seshtype = $_SESSION['sessiontype'];
                    $adminID = $_SESSION['adminid'];
                    $uName = $_SESSION['username'];
                    echo "{$seshtype}";
                    echo "{$adminID}";
                    echo "{$uName}";
                ?>
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
                            <input required class="input" type="text" name="new_ref_name" placeholder="New Referee name">
                        </div>
                        <div class='my_medium_form_item level-item'>
                            <button name="change_ref" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Referee Name</button>
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
                            <button name="change_club" class='button my_medium_form_item mx-3 is-rounded is-danger level-item'>Change Club Name</button>
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
                            <button name="delete_club" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Club</button>
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
                            <button name="delete_ref" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Referee</button>
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
                            <button name="delete_season" class='is-pulled-left mx-3 button my_medium_form_item is-rounded is-danger level-item'>Delete Season</button>
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