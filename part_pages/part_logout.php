<?php
    session_start();
    if (isset($_GET['logout'])) {
        unset($_SESSION);
        session_destroy();
        session_write_close();
        session_regenerate_id(true);
        header("Location: http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/index.php");
        die();
    }
?>