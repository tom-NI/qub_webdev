<?php
    // admin sign in logic
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
            if (password_verify($userPassword, $dbPassword)) {
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