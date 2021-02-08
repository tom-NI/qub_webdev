<?php
    $refereeNameQuery = "SELECT RefereeName FROM `epl_referees` ORDER BY RefereeName ASC;";

    $clubNameQuery = "SELECT DISTINCT epl_clubs.ClubName FROM `epl_clubs` 
        INNER JOIN epl_matches ON epl_matches.HomeClubID = epl_clubs.ClubID
        INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
        WHERE epl_seasons.SeasonID = 1021 ORDER BY ClubName ASC;";
    

?>