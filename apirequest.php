<?php
    $endpoint = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?2018";
    $resource = file_get_contents($endpoint);
    $eplMatchData = json_decode($resource, true);
?>