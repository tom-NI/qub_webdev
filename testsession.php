<?php
    session_start();
    if (isset($_SESSION['sessiontype'])) {
        echo $_SESSION["sessiontype"];
        echo $_SESSION["adminid"];
        echo $_SESSION["username"];
    } else {
        echo "no session set!";
    }
?>