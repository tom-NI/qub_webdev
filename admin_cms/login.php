<?php
    session_start();
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    include_once(__DIR__ . "/../logic_files/dbconn.php");
    include_once(__DIR__ . "/../logic_files/admin_login_logic.php");
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
                <h1 class="title mt-4 is-size-3 is-size-5-mobile">Administrator Login</h1>
            </div>
        </div>
    </section>

    <div class="columns is-desktop master_site_width mt-6 ">
        <div class="column is-6 is-offset-3">
            <?php 
                if(isset($replyMessage)) {
                echo "<div class='my-3 p-5 has-background-warning'>
                        <div>
                            <h3 class='title is-5'>{$replyMessage}</h3>
                        </div>
                    </div>";
                }
            ?>
            <div class="my_info_colour p-3">
                <h2 class='title is-4 pt-4 is-size-5-mobile my_info_colour'>Login :</h2>
                <form class='form control' method="POST"
                    action="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/admin_cms/login.php">
                    <div class="field">
                        <label class='label mt-3 has-text-left my_info_colour' for="">Email address:</label>
                        <div class="control">
                            <input class='input has-text-left' required type="text" placeholder='email@email.com' name="user_email">
                        </div>
                    </div>
                    <div class="field mt-3">
                        <label class='label has-text-left my_info_colour'>Password:</label>
                        <div class="control">
                            <input class='input has-text-left' required type="password" placeholder='password' name="user_password">
                        </div>
                    </div>
                    <div class="">
                        <button class='button is-danger m-3' name='signin_btn'>
                            <span class="icon">
                                <i class="fas fa-pen-fancy"></i>
                            </span>
                            <span>Sign in</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include(__DIR__ . "/../part_pages/part_site_footer.php"); ?>
</body>
</html>