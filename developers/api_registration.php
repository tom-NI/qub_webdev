<?php
    use PHPMailer\PHPMailer\PHPMailer;
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    include_once(__DIR__ . "/../logic_files/dbconn.php");
    include_once(__DIR__ . "/../logic_files/api_registration_logic.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once(__DIR__ . "/../part_pages/all_page_dependencies.php"); ?>
    <title>EPL - Login / Register</title>
</head>
<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php include(__DIR__ . "/../part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">Developer API Registration</h1>
            </div>
        </div>
    </section>

    <div class="columns is-desktop master_site_width mt-6 ">
        <div class="column is-6 is-offset-3">
            <?php 
                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    echo "<div class='my-3 p-5 has-background-warning'>
                            <div>
                                <h3 class='title is-5'>{$displayMessage}</h3>
                            </div>
                        </div>";
                }
            ?>

            <!-- registration section -->
            <div class="my_grey_highlight_para p-3 mt-1">
                <div class="mt-3">
                    <h2 class='title is-4 is-size-5-mobile p-4'>Register for a developer API key</h2>
                    <p class="has-text-left is-size-6-mobile">* Required Fields</p>
                    <form class="form control" action="api_registration.php" method="POST">
                        <div>
                            <label class="label mt-3 has-text-left is-size-6-mobile" for="">* First Name :</label>
                            <div class='control'>
                                <input class="input" required name="developer_firstname" type="text" minlength="3" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left is-size-6-mobile" for="">* Surname :</label>
                            <div class='control'>
                                <input class="input" required name="developer_surname" type="text" minlength="1" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left is-size-6-mobile" for="">* Email address :</label>
                            <p class="has-text-left m-2 is-size-7-mobile">The key will be sent to the email address entered here.</p>
                            <div class='control'>
                                <input class="input" required name="developer_email" type="email">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left is-size-6-mobile" for="">* Organisation Name : (max 20 characters)</label>
                            <div class='control'>
                                <input class="input" required minlength='4' maxlength='20' name="developer_org" type="text">
                            </div>
                        </div>
                        <div>
                        <button class="button is-danger m-4" name="register_for_api">
                            <span class="icon">
                                <i class="far fa-clipboard"></i>
                            </span>
                            <span>Register</span>
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php include(__DIR__ . "/../part_pages/part_site_footer.php"); ?>
    
</body>
</html>