<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['register_for_api'])) {
            $userFirstName = htmlentities(trim($_POST['developer_firstname']));
            $userSurname = htmlentities(trim($_POST['developer_surname']));
            $userEmail = htmlentities(trim($_POST['developer_email']));
            $userOrganisation = htmlentities(trim($_POST['developer_org']));

            $stmt = $conn->prepare("SELECT * FROM `epl_api_users` WHERE UserEmail = ? ");
            $stmt -> bind_param("s", $userEmail);
            $stmt -> execute();
            $stmt -> store_result();

            if ($stmt->num_rows > 0) {
                // user email exists, reject new request
                $displayMessage = "That email already has an API key, please refer to the email sent at registration for key details.";
            } else {
                // user doesnt exist, so generate and send them their key
                // generate a unique key;
                $usersKey = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

                // develop and send the user an email with their details
                $emailSubject = "English Premier League - Developer API Key";
                $emailFrom = "EPL API Team";

                // get the body of the full email sent to user
                require(__DIR__ . "/../email_templates/api_key_email.php");

                $emailResult = sendEmail($userEmail, $userFirstName, $emailBody, $emailSubject, $emailFrom);
                if ($emailResult) {
                    $stmt = $conn->prepare("INSERT INTO `epl_api_users` (`id`, `UserFirstName`, `UserSecondName`, `UserEmail`, `UserKey`, `OrganisationName`) VALUES (NULL, ?, ?, ?, ?, ? ); ");
                    $stmt -> bind_param("sssss",
                                $userFirstName,
                                $userSurname,
                                $userEmail,
                                $usersKey,
                                $userOrganisation        
                            );
                    $stmt -> execute();
                    $stmt -> store_result();
                    $displayMessage = "Please check your email for your API key.";
                } else {
                    $displayMessage = "There was an issue sending your API key, please try again later";
                }
            }
        }
    }
?>