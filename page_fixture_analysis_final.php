<?php
    require("page_fixture_core.php");

    // data and icons for each tile (to be looped thru)
    $keyTileTitles = array(
        "Past Meetings",
        "Total Draws",
        "Average total goals per game",
        "Average total shots per game",
        "Average total fouls per game"
    );
    $keyIcons = array(
        "<i class='fas fa-user-friends'></i>",
        "<i class='fas fa-equals'></i>",
        "<i class='far fa-futbol'></i>",
        "<i class='fas fa-bullseye'></i>",
        "<span class='material-icons'>sports</span>"
    );                     

    $allTimeTileTitles = array(
        "Goals Scored",
        "Shots on Goal",
        "Fouls",
        "Yellow Cards",
        "Red Cards"
    );

    $metricTileTitles = array(
        "Percentage wins",
        "Win count",
        "% clean sheets",
        "Games Won by Half Time",
        "Goals per game",
        "Shots per game",
        "Shots on target",
        "Clean Sheets",
        "Average corners per game",
        "Fouls per game",
        "Yellow Cards per game",
        "Red Cards per game"
    );

    $clubA;
    $clubB;
    $teamAString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$clubA}</b></h4>";
    $teamBString = "<h4 class='is-size-4 is-size-5-mobile has-text-right team_a_name_colour'><b>{$clubB}</b></h4>";
?>

    <div class="column is-8 is-offset-2 my_sticky_div">
            <div class="container column box is-centered my_sticky_div py-4 mx-5">
                <div class="columns is-mobile is-vcentered is-centered">
                    <div class="column">
                        <?php
                            echo $teamAString;
                        ?>
                    </div>
                    <div class="column level is-narrow mt-5">
                        <h4 class="level-item">vs.</h4>
                    </div>
                    <div class="column">
                        <?php
                            echo $teamBString;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- all tiles below -->
        <div class="master_site_width columns is-desktop ">
            <section class="column is-centered is-offset-one-fifth mx-5">
                <!-- main stat section of the page -->
                <div class="columns level my-2 mt-5">
                    <h2 class="title is-4">Key Statistics:</h2>
                </div>

                <?php
                    for ($i = 0; $i < count($keyTileTitles); $i++) {
                        $currentIcon = $keyIcons[$i];
                        echo "
                            <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                                <div class='image is-24x24 ml-5'>
                                    {$currentIcon}
                                </div>
                                <div class='column is-half'>
                                    <p class='subtitle is-6 has-text-left ml-3'>{$title}</p>
                                </div>
                                <div class='column my_info_colour box my_dont_wrap_text m-3 mx-5'>
                                    <p class='subtitle is-5 m-0 my_stat_font is-one-fifth' id='fixture_total_meets_amount'><b>{$calcValue}</b>
                                    </p>
                                </div>
                            </div>";
                    }
                ?>

                <div class="columns level my-2 mt-6">
                    <h2 class="title is-4 ">Highest all Time statistics by match:</h2>
                </div>

                <!-- most goals scored -->
                <?php
                    for ($i = 0; $i < count($allTimeTileTitles); $i++) {
                        $currentWords = $allTimeTileTitles[$i];
                        $teamAStatistic; 
                        $teamADate;
                        $teamBStatistic;
                        $teamBDate;
                        echo "
                            <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                            <div class='column team_a_colour box my_dont_wrap_text m-3 mx-5'>
                                <p class='subtitle is-6 m-0 my_stat_font' id='team_a_goals_amount'><b>{$teamAStatistic}</b></p>
                                <p class='m-0 mt-1 subtitle is-7 my_stat_font' id='team_a_goals_scored_date'>{$teamADate}</p>
                            </div>
                            <div class='column is-one-third'>
                                <p class='subtitle is-6'>{$currentWords}</p>
                            </div>
                            <div class='column team_b_colour box my_dont_wrap_text m-3 mx-5'>
                                <p class='subtitle is-6 m-0 my_stat_font' id='team_b_goals_amount'><b>{$teamBStatistic}</b></p>
                                <p class='m-0 mt-1 subtitle is-7 my_stat_font' id='team_b_goals_scored_date'>{$teamBDate}</p>
                            </div>
                        </div>";
                    }
                ?>
            </section>

            <section class="column mx-5">
                <!-- section header -->
                <div class="columns level my-2 mt-5">
                    <h2 class="title is-4">Metric Comparison:</h2>
                </div>
                <?php
                    for ($i = 0; $i < count($metricTileTitles); $i++) {
                        $currentWording = $metricTileTitles[$i];
                        $teamAstat = "";
                        $teamBstat = "";
                        
                        echo "
                            <div class='columns is-vcentered is-mobile level m-4 my_fixture_stat_level'>
                                <div class='column team_a_colour box my_dont_wrap_text m-3 mx-5'>
                                    <p class='subtitle is-6 m-0 my_stat_font'><b>{$teamAstat}</b></p>
                                </div>
                                <div class='column is-one-third'>
                                    <p class='subtitle is-6'>{$currentWording}</p>
                                </div>
                                <div class='column team_b_colour box my_dont_wrap_text m-3 mx-5'>
                                    <p class='subtitle is-6 m-0 my_stat_font'><b>{$teamBstat}</b></p>
                                </div>
                            </div>";
                    }
                ?>
            </section>
        </div>
    </div>

    <?php require("part_site_footer.php"); ?>
    <script src="my_script.js"></script>
</body>

</html>