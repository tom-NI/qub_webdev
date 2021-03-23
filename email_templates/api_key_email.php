<?php 
    $emailBody = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>EPL Developer API Key</title>
    </head>
    <body>
    <h3>Hi {$userFirstName}.</h3>
    <h4>Thank you for your interest in the English Premier League - Match Statistic Finder API.</h4>

    <p>You have set your Organization name as : </br>{$userOrganisation}</p>

    <p>Your API key is :  </br>{$usersKey}</p>

    <p>To authenticate all API requests, you must provide BOTH pieces of information in a basic Auth header. </br>
    i.e. Your organisation name is a proxy for auth username, and your API key is a proxy for the auth password. </p>

    <p>Our API route endpoint is </br> http://tkilpatrick01.lampt.eeecs.qub.ac.uk/epl_api_v1 </p>
    <p>You can add the following paths to select data: 
    <p>referees</p>
    <p>clubs</p>
    <p>seasons</p>
    <p>full_matches</p>
    <p>match_summaries</p>

    <p>Please retain this email and keep your key secure - do not share the API key with anyone. </p>
    <p>Kind Regards,</br>API team. </p>

    <p>English Premier League, Match Statistic Finder Website.</br>
    <p>The site for Premier League Match Statistics </p>

    </body>
    </html>";
?>