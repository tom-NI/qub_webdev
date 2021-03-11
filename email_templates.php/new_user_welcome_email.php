<?php
    $emailBody = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
        </head>
        <body>
        <h3>Hi {$userFirstName}</h3>.
        <h3>Welcome to the Match Statistic finder website, thank you for registering.</h3>
        
        <p>Please click the link below to validate your email address and start adding match results to our site.</p>
        <a href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/login.php?validate_user&num={$lastID}'><p>Validate My Email Address</p></a>
        </body>
        </html>
    ";
?>