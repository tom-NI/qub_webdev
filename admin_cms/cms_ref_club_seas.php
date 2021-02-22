
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../mystyles.css">
    <title>Add Referee, club or season</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php
        include("../part_site_navbar.php"); 
    ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Add Data</h1>
                <p class="subtitle is-5 mt-2">Add data to the site database</p>
            </div>
        </div>
    </section>

    <div class="has-text-centered master_site_width container columns" id="my_upload_result_form">
        <div class="column is-8 is-offset-2">
            <div class="mt-5 p-5 my_grey_highlight_para">
                <!-- Add ref -->
                <h2 class="title is-5 mt-3 mb-1">Add new Referee;</h2>
                <div class="">
                    <p class="p-2">Please enter Referee in the format "First initial. Surname" e.g. A. Referee</p>
                    <form method="POST" action="logic_ref_club_season.php" class="level columns">
                        <input type="text" required id="new_referee" name="newrefname" class="input level-item column is-5 is-half-tablet" placeholder="Referee Name">
                        <button class="button level-item is-info m-3 is-rounded ">Add Referee</button>
                    </form>
                </div>
                <h2 class="title is-5 mt-5 mb-1">Add new Season;</h2>
                <div class=""> 
                    <p class="p-2">Please enter a season in the format "firstyear-secondyear" with 4 digits for each year e.g. 2000-2001</p>
                    <?php
                        require("../allfunctions.php");
                        $suggestedNextSeason = findNextSuggestedSeason();
                        echo "
                        <form method='POST' action='logic_ref_club_season.php' class='level columns'>
                            <input type='text' required id='new_season' name='new_season' class='input level-item column is-5 is-half-tablet' placeholder='Suggested next season to add : {$suggestedNextSeason}'>
                            <button class='button level-item is-info m-3 is-rounded my-3 '>Add New Season</button>
                        </form>";
                    ?>
                </div>
                <h2 class="title is-5 mt-5 mb-1">Add new Club;</h2>
                <div class="">
                    <p class=" p-1">Please use the official club name and do not abbreviate.  Adding "football club" at the end is not required.</p>
                    <p class="p-1">Club Logo URL must link directly to a .jpg or .png image file</p>
                    <form method="POST" action="logic_ref_club_season.php" class="level columns">
                        <input type="text" required id="new_club" name="new_club" class="input level-item column is-3 mx-2 is-one-third-tablet" maxlength="35" placeholder="Club Name (max 35 Characters)">
                        <input type="url" required id="new_club_img_url" name="new_club_img_url" class="input level-item column is-3 mx-5 is-one-third-tablet" placeholder="Club Logo URL">
                        <button class="button level-item is-info is-rounded mt-4 my-3 ">Add New Club</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include("../part_site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>