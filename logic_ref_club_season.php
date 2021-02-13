<?php
    if (isset($_POST['adddata'])) {
        $userEntry = $_POST["adddata"];
        
        if ($userEntry == "referee") {
            if(isset($_POST["refname"])) {
                $refName = real_escape_string(trim($_POST['refname']));
                // todo check regex format of Ref name and surname length!


            } else {
                echo "enter referee name";
            }
        } elseif ($userEntry == "season") {
            if(isset($_POST["season"])) {
                $refName = real_escape_string(trim($_POST['season']));
                // todo - regex check the format of the season!


            } else {
                echo "enter referee name";
            }
        } elseif ($userEntry == "club") {
            if(isset($_POST["club"])) {
                $refName = real_escape_string(trim($_POST['club']));
                // check length of the club is sensible?


            } else {
                echo "Enter club name";
            }
        } else {
            echo "No entry provided";
        }
    }



?>