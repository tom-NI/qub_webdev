<?php
    session_start();
    include_once("../logic_files/allfunctions.php");
    include_once("../logic_files/dbconn.php");

    // admin sign in 
    if (isset($_POST['signin_btn'])) {
        $userEmail = htmlentities(trim($_POST['user_email']));
        $userPassword = htmlentities(trim($_POST['user_password']));
        
        $stmt = $conn->prepare("SELECT AdminId, AdminName, Password FROM `epl_admins` WHERE AdminEmail = ? ;");
        $stmt -> bind_param("s", $userEmail);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result($administratorID, $userName, $dbPassword);
        $stmt -> fetch();

        if ($stmt->num_rows == 1) {
            // user email exists, check passwords
            if ($userPassword === $dbPassword) {
                $_SESSION['sessiontype'] = "admin";
                $_SESSION['userid'] = $administratorID;
                $_SESSION['username'] = $userName;
                header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/admin_cms/manage_data.php");
            } else {
                $replyMessage = "Password Doesnt match, please try again";
            }
        } else {
            $replyMessage = "Login failed, please try again";
        }
    }
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
    <?php include("../part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Administrator Login</h1>
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
                <h2 class='title is-4 pt-4 my_info_colour'>Login :</h2>
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
                        <button class='button is-danger m-3' name='signin_btn'>Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include("../part_pages/part_site_footer.php"); ?>
</body>
</html>