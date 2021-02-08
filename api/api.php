<?php
    header('Content-Type: application/json');
    
    if (isset($_GET['2018'])) {
        include("../dbconn.php");
        $masterSqlQuery = "SELECT epl_matches.MatchID, epl_seasons.SeasonYears, epl_matches.MatchDate, epl_referees.RefereeName, epl_matches.HomeClubID, epl_matches.AwayClubID, epl_home_team_stats.HTTotalGoals, epl_home_team_stats.HTHalfTimeGoals, epl_home_team_stats.HTShots, epl_home_team_stats.HTShotsOnTarget, epl_home_team_stats.HTCorners, epl_home_team_stats.HTFouls, 
        epl_home_team_stats.HTYellowCards, epl_home_team_stats.HTRedCards, epl_away_team_stats.ATTotalGoals, 
        epl_away_team_stats.ATHalfTimeGoals, epl_away_team_stats.ATShots, epl_away_team_stats.ATShotsOnTarget, 
        epl_away_team_stats.ATCorners, epl_away_team_stats.ATFouls, epl_away_team_stats.ATYellowCards, epl_away_team_stats.ATRedCards
        FROM epl_matches
        INNER JOIN epl_home_team_stats ON epl_matches.MatchID = epl_home_team_stats.MatchID 
        INNER JOIN epl_away_team_stats ON epl_matches.MatchID = epl_away_team_stats.MatchID
        INNER JOIN epl_seasons ON epl_matches.SeasonID = epl_seasons.SeasonID
        INNER JOIN epl_referees ON epl_referees.RefereeID = epl_matches.RefereeID
        INNER JOIN epl_clubs ON epl_clubs.ClubID = epl_matches.HomeClubID
        ORDER BY MatchID ASC;";

        $queryValue = $conn->query($masterSqlQuery);
        if (!$queryValue) {
            echo $conn->error;
            die();
        }

        $matchDataSet = array();

        while($row = $queryValue->fetch_assoc()) {
            $homeClubID = $row["HomeClubID"];
            $awayClubID = $row["AwayClubID"];

            $homeClubNameQuery = "SELECT epl_clubs.ClubName AS 'HomeTeam', epl_clubs.ClubLogoURL AS 'HomeLogoURL' FROM `epl_clubs` WHERE ClubID = {$homeClubID}";
            $awayClubNameQuery = "SELECT epl_clubs.ClubName AS 'AwayTeam', epl_clubs.ClubLogoURL AS 'AwayLogoURL'FROM `epl_clubs` WHERE ClubID = {$awayClubID}";

            $homeClubQuery = $conn->query($homeClubNameQuery);
            if (!$homeClubQuery) {
                echo $conn->error;
                die();
            }

            $awayQueryValue = $conn->query($awayClubNameQuery);
            if (!$awayQueryValue) {
                echo $conn->error;
                die();
            }
            
            $matchDataSet[] = $row["MatchID"];
            $matchDataSet[] = $row["SeasonYears"];
            $matchDataSet[] = $row["MatchDate"];
            $matchDataSet[] = $row["RefereeName"];

            while ($row = $homeClubQuery->fetch_assoc()) {
                $matchDataSet[] = $row["HomeTeam"];
                $matchDataSet[] = $row["HomeLogoURL"];
            }

            while ($row = $awayQueryValue->fetch_assoc()) {
                $matchDataSet[] = $row["AwayTeam"];
                $matchDataSet[] = $row["AwayLogoURL"];
            }

            $matchDataSet[] = $row["HTTotalGoals"];
            $matchDataSet[] = $row["HTHalfTimeGoals"];
            $matchDataSet[] = $row["HTShots"];
            $matchDataSet[] = $row["HTShotsOnTarget"];
            $matchDataSet[] = $row["HTCorners"];
            $matchDataSet[] = $row["HTFouls"];
            $matchDataSet[] = $row["HTYellowCards"];
            $matchDataSet[] = $row["HTRedCards"];
            $matchDataSet[] = $row["ATTotalGoals"];
            $matchDataSet[] = $row["ATHalfTimeGoals"];
            $matchDataSet[] = $row["ATShots"];
            $matchDataSet[] = $row["ATShotsOnTarget"];
            $matchDataSet[] = $row["ATCorners"];
            $matchDataSet[] = $row["ATFouls"];
            $matchDataSet[] = $row["ATYellowCards"];
            $matchDataSet[] = $row["ATRedCards"];
        }
        echo json_encode($matchDataSet);
    }
?>