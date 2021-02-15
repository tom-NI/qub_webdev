<?php
    require("allfunctions.php");
    if (isset($_POST["newrefname"])) {
        $userRefNameEntry = trim($_POST['newrefname']);
        if ($userRefNameEntry != null && strlen($userRefNameEntry) > 0) {
            $finalRefName = htmlentities($userRefNameEntry);
            // todo check regex format of Ref name and surname length!
            $refRegex = '/[A-Z]{1}. [A-Z]{1}[a-z]+/';
            if (preg_match($refRegex, $finalRefName)) {
                $sqlAddRefQuery = "INSERT INTO `epl_referees` (`RefereeID`, `RefereeName`) VALUES (NULL, '{$finalRefName}')";
                dbQueryAndCheck($sqlAddRefQuery);
                $userDisplayedMessage = "Referee {$finalRefName} was added to the database successfully";
            } else {
                include("part_site_navbar.php");
                $userDisplayedMessage = "Please match the referee name format precisely and re-enter e.g. A. Referee";
            }
        } else {
            $userDisplayedMessage = "Please enter a valid value";
        }
    } elseif (isset($_POST["new_season"])) {
        $userSeasonEntry = trim($_POST['new_season']);
        $finalUserSeasonEntry = htmlentities($userSeasonEntry);
        // todo - regex check the format of the season!
        $seasonRegex = '/2[0-9]{3}-2[0-9]{3}/';
        $seasonYearsCorrectOrder = checkSeasonYearOrder($finalUserSeasonEntry);
        if (preg_match($seasonRegex, $finalUserSeasonEntry) && $seasonYearsCorrectOrder) {
            $allSeasonsAPIurl = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/api/api.php?list=all_seasons_list";
            $allSeasonsAPIdata = file_get_contents($allSeasonsAPIurl);
            $fixtureList = json_decode($allSeasonsAPIdata, true);

            foreach ($fixtureList as $existingSeason) {
                if ($finalUserSeasonEntry == $existingSeason['season']) {
                    include("part_site_navbar.php");
                    $userDisplayedMessage = "The {$finalUserSeasonEntry} season already exists in the database, please do not add duplicate data.</p>";
                } else {
                    $suggestedNextSeason = findNextSuggestedSeason();
                    if ($finalUserSeasonEntry != $suggestedNextSeason) {
                        echo "<p>Season Year doesnt match the year suggested (i.e. {$suggestedNextSeason}), please re-enter</p>";
                    } else {
                        $sqlAddSeasonQuery = "INSERT INTO `epl_seasons` (`SeasonID`, `SeasonYears`) VALUES (NULL, '{$finalUserSeasonEntry}')";
                        dbQueryAndCheck($sqlAddSeasonQuery);
                        $userDisplayedMessage = "Season {$finalUserSeasonEntry} was added to the database successfully";
                    }
                }
            }
        } else {
            $userDisplayedMessage = "Season {$finalUserSeasonEntry} has NOT been added to the database \n
                                    Please match the requested Year format for Seasons and re-enter e.g. 2000-2001 \n
                                    Please also ensure the starting year comes first";
        }
    } elseif (isset($_POST["new_club"])) {
        $userClubNameEntry = trim($_POST['new_club']);
        $usersClubImgURL = real_escape_string(trim($_POST['new_club_img_url']));
        // html maxlength sets limit on the char entry - double check!
        if ($userClubNameEntry != null && $usersClubImgURL != null && strlen($userClubNameEntry) <= 35) {
            $finalUserClubNameEntry = htmlentities($userClubNameEntry);
            $finalUsersClubImgURL = htmlspecialchars($usersClubImgURL);
            $sqlAddClubQuery = "INSERT INTO `epl_clubs` (`ClubID`, `ClubName`, `ClubLogoURL`) VALUES (NULL, '{$finalUserClubNameEntry}', '{$finalUsersClubImgURL}');";

            // todo - add data to db
            $userDisplayedMessage = "Club {$finalUserClubNameEntry} was successfully added to the database.";
        } else {
            $userDisplayedMessage = "There was an issue with the Submission.  Please ensure the club name is less than 35 characters long and the image URL links directly to a .png or .jpg file";
        }
    } else {
        $userDisplayedMessage = "No entry provided";
    }
    
    include("part_site_navbar.php");
    echo "
        <div class='has-text-centered master_site_width container columns' id='my_upload_result_form'>
            <div class='column is-8 is-offset-2'>
                <div class='mt-5 p-5 my_info_colour'> 
                    <h3>{$userDisplayedMessage}</h3>
                </div>
            </div>
            <a type='button' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_add_new_result.php'> Return to previous page</a>
        </div>;"
?>
