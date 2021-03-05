<?php  
    include_once("logic_files/allfunctions.php");
    include_once("part_pages/api_auth.php");
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['signin_btn'])) {
            $userEmail = isset($_POST['user_email']);
            $userPassword = isset($_POST['user_password']);
            $securePassword = password_hash($userPassword1, PASSWORD_DEFAULT);

            // send user data in a header to API
            $userInfoArray = http_build_query(
                array(
                    'email' => $userFirstName,
                    'hashedpassword' => $securePassword
                )
            );
            $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?validate";
            $apiReply = postDataInHeader($endpoint, $userInfoArray);

            // decode reply from API
            $apiJSON = json_decode($apiReply, true);
            $reply = $row[0]["reply_message"];

            if ($reply != "Logged in") {
                header("Location: login.php");
                $displayMessage = $reply;
            } else {
                // TODO IS THIS EVEN CORRECT TO START A SESSION?
                session_start();
                $_SESSION['registereduser'];
                header("Location: admin_cms/manage_data.php");
                $displayMessage = "Welcome";
            }
        } elseif (isset($_POST['register_btn'])) {
            $displayMessage = "";
            $userFirstName = htmlentities(trim($_POST['register_firstname']));
            $userSurname = htmlentities(trim($_POST['register_surname']));
            $userEmail = htmlentities(trim($_POST['register_email']));
            $userPassword1 = htmlentities(trim($_POST['register_pw1']));
            $userPassword2 = htmlentities(trim($_POST['register_pw2']));

            if ($userPassword1 != $userPassword2) {
                $displayMessage = "Passwords Dont Match, please try again";
            } else {
                $securePassword = password_hash($userPassword1, PASSWORD_DEFAULT);
            }

            // TODO NEEDS A DIE STATEMENT IN HERE SOMEWHERE

            // send user data in a header to API
            $userInfoArray = http_build_query(
                array(
                    'firstname' => $userFirstName,
                    'surname' => $userSurname,
                    'email' => $userEmail,
                    'hashedpassword' => $securePassword
                )
            );
            $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1/users/?register";
            $apiReply = postDataInHeader($endpoint, $userInfoArray);

            // decode reply from API
            $apiJSON = json_decode($apiReply, true);
            $displayMessage = $apiJSON[0]["reply_message"];
            header("Location: login.php");
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
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <title>EPL - Login / Register</title>
</head>
<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php include("part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">User Login</h1>
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
            <div class="my_info_colour p-3">
                <h2 class='title is-4 pt-4 my_info_colour'>Sign In:</h2>
                <form class='form control' method="POST"
                    action="http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/admin_cms/manage_data.php">
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
            <div class="my_grey_highlight_para p-3 mt-6">
                <!-- registration section -->
                <div class="mt-3">
                    <h2 class='title is-4 pt-4'>Not yet a registered user?</h2>
                    <p class='mt-2'>Register here</p>
                    <form class="form control" action="" method="POST">
                        <div>
                            <label class="label mt-3 has-text-left" for="">First Name :</label>
                            <div class='control'>
                                <input class="input" required name="register_firstname" type="text" minlength="3" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">Surname :</label>
                            <div class='control'>
                                <input class="input" required name="register_surname" type="text" minlength="3" maxlength="15">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">Email address :</label>
                            <div class='control'>
                                <input class="input" required name="register_email" type="email">
                            </div>
                        </div>
                        <div>
                            <label class="label mt-3 has-text-left" for="">Password :</label>
                            <div class='control'>
                                <input class="input " required name="register_pw1" type="password" placeholder="Enter your desired password here - Minimum 8 characters">
                            </div>
                            <label class="label mt-3 has-text-left" for="">Please reenter password :</label>
                            <div class='control'>
                                <input class="input" required name="register_pw2" type="password" placeholder="Reenter password here - identical to the password above">
                            </div>
                        </div>
                        <div>
                            <button class="button is-danger m-4" name="register_btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php include("part_pages/part_site_footer.php"); ?>
    
</body>
</html>