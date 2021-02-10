<?php
if( ($_SERVER['PHP_AUTH_USER'] == "tom" ) && ( $_SERVER['PHP_AUTH_PW'] == "lockdown" ))
    {
        echo "Valid username and password.";
    } else {
        header("WWW-Authenticate: Basic realm='Admin Dashboard'");
        header("HTTP/1.0 401 Unauthorized");
        echo "You need to enter a valid username and password.";
        exit;
    }
?>
 
<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Admin</title>
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
<link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
<link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
 
<body>
 
 <div class="container">
 
        <div class="row">
                <div class="column">
                    <h1>Dashboard</h1>
                </div>
        </div>
        <div class="row">
                <div class="column">
                  <h4>Stuff</h4>
                  <a class="button" href="dostuff.php">Function Button</a>
                </div>
        </div>
       
         <div class="row">
                <div class="column">
                  <h4>build JSON response</h4>
 
                 
                </div>
        </div>
       
 </div>
 
</body>
</html>
