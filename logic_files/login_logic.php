<?php
    include_once(__DIR__ . "/dbconn.php");
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET'
            && isset($_GET['validate_user']) && isset($_GET['id'])) {
        // user trying to validate their user account via the link provided in an email
        // i dont know any other way in an email link to validate the account only using GET
        $userID = htmlentities(trim($_GET['id']));
        $stmt = $conn->prepare("SELECT id, UserEmailConfirmed FROM `epl_site_users` WHERE id = ? ;");
        $stmt -> bind_param("i", $userID);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result($usersID, $emailConfirmedBoolean);
        $stmt -> fetch();

        if ($stmt->num_rows > 0) {
            if ($emailConfirmedBoolean == 0) {
                $stmt = $conn->prepare("UPDATE `epl_site_users` SET `UserEmailConfirmed` = 1 WHERE `epl_site_users`.`id` = ? ");
                $stmt -> bind_param("i", $usersID);
                $stmt -> execute();
                if ($stmt) {
                    $replyMessage = "Account verified, please login";
                } else {
                    $replyMessage = "Account not verified, please try again";
                }
            } else {
                $replyMessage = "Account previously verified, please login";
            }
        } else {
            $replyMessage = "Unknown Request, please try again";
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // registering or signing in
        if (isset($_POST['user_email'])) {
            require(__DIR__ . "/logout_logic.php");
            $userEmail = htmlentities(trim($_POST['user_email']));
            $userPassword = htmlentities(trim($_POST['user_password']));
            
            $stmt = $conn->prepare("SELECT id, UserName, UserPassword FROM `epl_site_users` WHERE UserEmail = ? ;");
            $stmt -> bind_param("s", $userEmail);
            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result($userID, $userName, $passwordToCompare);
            $stmt -> fetch();
            
            if ($stmt->num_rows == 1) {
                // user email exists, check hashed passwords
                if (password_verify($userPassword, $passwordToCompare)) {
                    $_SESSION['sessiontype'] = "user";
                    $_SESSION['userid'] = $userID;
                    $_SESSION['username'] = $userName;
                    header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/index.php");
                } else {
                    $replyMessage = "Password Doesnt match, please try again";
                }
            } else {
                $replyMessage = "Login failed, please try again";
            }
        } elseif (isset($_POST['register_btn'])) {
            $userFirstName = htmlentities(trim($_POST['register_firstname']));
            $userSurname = htmlentities(trim($_POST['register_surname']));
            $userEmail = htmlentities(trim($_POST['register_email']));
            $userPassword1 = htmlentities(trim($_POST['register_pw1']));
            $userPassword2 = htmlentities(trim($_POST['register_pw2']));

            if ($userPassword1 !== $userPassword2) {
                $displayMessage = "Passwords Dont Match, please try again";
            } else {
                // check user doesnt already exist first!
                $stmt = $conn->prepare("SELECT id FROM `epl_site_users` WHERE UserEmail = ? ;");
                $stmt -> bind_param("s", $userEmail);
                $stmt -> execute();
                $stmt -> store_result();
                if ($stmt->num_rows < 1) {
                    $securePassword = password_hash($userPassword1, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO `epl_site_users` (`id`, `UserName`, `UserSurname`, `UserEmail`, `UserPassword`, `UserEmailConfirmed`) VALUES (NULL, ?, ?, ?, ?, 0) ;");
                    $stmt -> bind_param("ssss",
                                    $userFirstName,
                                    $userSurname,
                                    $userEmail,
                                    $securePassword
                                );
                    $stmt -> execute();
                    $stmt -> store_result();
                    $lastID = $conn -> insert_id;
                    
                    // send user an email
                    $emailSubject = "EPL Match Statistic Finder";
                    $emailFrom = "EPL - Match Statistics Team";

                    // body of the full email sent to user
                    require(__DIR__ . "/email_templates/new_user_welcome_email.php"); 
                    
                    // send user email confirmation
                    $emailConfirmation = sendEmail($userEmail, $userFirstName, $emailBody, $emailSubject, $emailFrom);

                    if($stmt) {
                        $replyMessage = "Check your inbox to validate your account.";
                        header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/login.php");
                    } else {
                        http_response_code(400);
                        $replyMessage = "Login failed, please try again";
                    }
                } else {
                    $replyMessage = "Account already exists, please login";
                    header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/login.php");
                }
            }
        } else {
            $replyMessage = "Unknown request, please try again";
        }
    }
?>