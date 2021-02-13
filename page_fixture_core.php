
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fixture Analysis</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">Fixture Analysis</h1>
                <p class="subtitle is-5 mt-1">Select teams to analyse all previous meetings</p>
            </div>
        </div>
    </section>

    <!-- main site content -->
    <div class="master_site_width">
        <section class="columns is-mobile is-vcentered m-2 mx-5 pt-4">
            <div class="column is-8-desktop is-offset-2-desktop my_info_colour">
                <div class="column p-4 mx-3">
                    <form class="level columns form">
                        <div class="column level-item">
                            <div class="select control is-expanded is-success">
                                <select name='' id='fixture_ht_selector' class=''>
                                    <?php
                                        require("part_team_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="column level-item">
                            <div class="select control is-expanded is-danger">
                                <select name='' id='fixture_at_selector' class=''>
                                    <?php
                                        require("part_team_selector.php");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="column is-centered mt-0 level-item">
                            <div class="m-1">
                                <input type="checkbox" id="strict_search_box" checked name="strict">
                                <label for="strict_search_box">Include Reverse Fixtures</input>
                                <button type="submit" id="fixture_search_btn" class="button is-rounded is-danger">Search</button>
                            </div>

                        </div>
                    </form>
                </div>
                <p class="subtitle is-6 mt-1 my_info_colour">Remove reverse search to search Home and Away clubs as input</p>
            </div>
        </section>