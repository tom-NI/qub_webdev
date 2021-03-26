<?php
    use PHPMailer\PHPMailer\PHPMailer;
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    include_once(__DIR__ . "/../logic_files/dbconn.php");
    include_once(__DIR__ . "/../logic_files/api_registration_logic.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../stylesheets/mystyles.css">
    <title>EPL - Login / Register</title>
</head>
<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php include(__DIR__ . "/../part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Developer API Registration</h1>
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
                    <h2 class='title is-4 p-4'>Register for a developer API key</h2>
                    <p class="has-text-left">* Required Fields</p>
                    <form class="form control" action="api_registration.php" method="POST">
                        <div>
                            <label class="label mt-3 has-text-left" for="">* First Name :</label>
                            <div class='control'>
                                <input class="input" required name="developer_firstname" type="text" minlength="3" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">* Surname :</label>
                            <div class='control'>
                                <input class="input" required name="developer_surname" type="text" minlength="1" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">* Email address :</label>
                            <p class="has-text-left m-2">The key will be sent to the email address entered here.</p>
                            <div class='control'>
                                <input class="input" required name="developer_email" type="email">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">* Organisation Name : (max 20 characters)</label>
                            <div class='control'>
                                <input class="input" required minlength='4' maxlength='20' name="developer_org" type="text">
                            </div>
                        </div>
                        <div>
                            <button class="button is-danger m-4" name="register_for_api">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php include(__DIR__ . "/../part_pages/part_site_footer.php"); ?>
    
</body>
</html>