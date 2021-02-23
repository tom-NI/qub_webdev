<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/mystyles.css">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>EPL Match Result</title>
</head>

<body class="has-navbar-fixed-top is-family-sans-serif">
    <?php include("part_pages/part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-2">Match Result</h1>
            </div>
        </div>
    </section>

    <!-- main page starts here -->
    <?php
        include_once("logic_files/allfunctions.php");
        if (isset($_GET['id'])) {
            $postedMatchID = $_GET['id'];
            $singleMatchURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/epl_api_v1/full_match?onematch={$postedMatchID}";
            require("part_pages/api_auth.php");
            $singleMatchData = file_get_contents($singleMatchURL, false, $context);
            $singleMatchList = json_decode($singleMatchData, true);

            foreach($singleMatchList as $singleMatchInfo) {
                $matchdate = $singleMatchInfo['matchdate'];
                $kickofftime = $singleMatchInfo['kickofftime'];
                $refereename = $singleMatchInfo['refereename'];
                $hometeam = $singleMatchInfo['hometeam'];
                $awayteam = $singleMatchInfo['awayteam'];
                $hometeamlogoURL = $singleMatchInfo['hometeamlogoURL'];
                $awayteamlogoURL = $singleMatchInfo['awayteamlogoURL'];

                $hometeamtotalgoals = $singleMatchInfo['hometeamtotalgoals'];
                $hometeamhalftimegoals = $singleMatchInfo['hometeamhalftimegoals'];
                $hometeamshots = $singleMatchInfo['hometeamshots'];
                $hometeamshotsontarget = $singleMatchInfo['hometeamshotsontarget'];
                $hometeamcorners = $singleMatchInfo['hometeamcorners'];
                $hometeamfouls = $singleMatchInfo['hometeamfouls'];
                $hometeamyellowcards = $singleMatchInfo['hometeamyellowcards'];
                $hometeamredcards = $singleMatchInfo['hometeamredcards'];

                $awayteamtotalgoals = $singleMatchInfo['awayteamtotalgoals'];
                $awayteamhalftimegoals = $singleMatchInfo['awayteamhalftimegoals'];
                $awayteamshots = $singleMatchInfo['awayteamshots'];
                $awayteamshotsontarget = $singleMatchInfo['awayteamshotsontarget'];
                $awayteamcorners = $singleMatchInfo['awayteamcorners'];
                $awayteamfouls = $singleMatchInfo['awayteamfouls'];
                $awayteamyellowcards = $singleMatchInfo['awayteamyellowcards'];
                $awayteamredcards = $singleMatchInfo['awayteamredcards'];
            }

            $htPercentShotsOT = calculatePercentage($hometeamshotsontarget, $hometeamshots);
            $atPercentShotsOT = calculatePercentage($awayteamshotsontarget, $awayteamshots);

            $htStatsForGraph = array($hometeamhalftimegoals,$hometeamshots,$hometeamshotsontarget,$htPercentShotsOT,$hometeamcorners,$hometeamfouls,$hometeamyellowcards,$hometeamredcards);
            $atStatsForGraph = array($awayteamhalftimegoals,$awayteamshots,$awayteamshotsontarget,$atPercentShotsOT,$awayteamcorners,$awayteamfouls,$awayteamyellowcards,$awayteamredcards);

            $presentableMatchDate = parseDateLongFormat($matchdate);
            if (strlen($kickofftime) > 0) {
                $kickoffParagraph = "<p class='p-2 mx-1 is-size-7-mobile'>Kick Off : {$kickofftime}</p>";
            } else {
                $kickoffParagraph = "";
            }
        } else {
            echo "<h2>page not found</h2>";
            die();
        } 

        // now analyse the previous 5 fixture for this match!
        $homeTeamSearched = addUnderScores($hometeam);
        $awayTeamSearched = addUnderScores($awayteam);
        $pastFixturesURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/epl_api_v1/?full_matches&fixture={$homeTeamSearched}~{$awayTeamSearched}&count=5&startat=2";
        $pastFixturesData = file_get_contents($pastFixturesURL);
        $pastFixturesList = json_decode($pastFixturesData, true);

        $hometeamtotalgoalsArray = array();
        $hometeamhalftimegoalsArray = array();
        $hometeamshotsArray = array();
        $hometeamshotsontargetArray = array();
        $hometeamcornersArray = array();
        $hometeamfoulsArray = array();
        $hometeamyellowcardsArray = array();
        $hometeamredcardsArray = array();

        $awayteamtotalgoalsArray = array();
        $awayteamhalftimegoalsArray = array();
        $awayteamshotsArray = array();
        $awayteamshotsontargetArray = array();
        $awayteamcornersArray = array();
        $awayteamfoulsArray = array();
        $awayteamyellowcardsArray = array();
        $awayteamredcardsArray = array();

        foreach($pastFixturesList as $fixture) {
            $hometeamtotalgoalsArray[] = $fixture['hometeamtotalgoals'];
            $hometeamhalftimegoalsArray[] = $fixture['hometeamhalftimegoals'];
            $hometeamshotsArray[] = $fixture['hometeamshots'];
            $hometeamshotsontargetArray[] = $fixture['hometeamshotsontarget'];
            $hometeamcornersArray[] = $fixture['hometeamcorners'];
            $hometeamfoulsArray[] = $fixture['hometeamfouls'];
            $hometeamyellowcardsArray[] = $fixture['hometeamyellowcards'];
            $hometeamredcardsArray[] = $fixture['hometeamredcards'];

            $awayteamtotalgoalsArray[] = $fixture['awayteamtotalgoals'];
            $awayteamhalftimegoalsArray[] = $fixture['awayteamhalftimegoals'];
            $awayteamshotsArray[] = $fixture['awayteamshots'];
            $awayteamshotsontargetArray[] = $fixture['awayteamshotsontarget'];
            $awayteamcornersArray[] = $fixture['awayteamcorners'];
            $awayteamfoulsArray[] = $fixture['awayteamfouls'];
            $awayteamyellowcardsArray[] = $fixture['awayteamyellowcards'];
            $awayteamredcardsArray[] = $fixture['awayteamredcards'];
 
        }
    ?>

        <div class='master_site_width'>
            <div class='mt-6 mx-4'>
                <div class='column is-desktop is-8 is-offset-2 is-12-mobile is-vcentered'>
                    <div class='container box columns is-centered my_box_border m-2 mb-5 p-3'>
                    <div class='columns level is-mobile is-centered'>
                        <div class='column is-narrow level-item'>
                            <div class='is-pulled-right'>
                                <?php echo "<img class='image is-96x96 m-4 my_image_maintain_aspect' src='{$hometeamlogoURL}' alt='Home Logo'>"; ?>
                            </div>
                        </div>
                        <div class='column is-centered level-centre'>
                            <div class='is-centered is-vertical'>
                                <p class='p-2 mx-1 is-size-7-mobile'> <?php echo "{$presentableMatchDate}"; ?> </p>
                                <?php echo "{$kickoffParagraph}"; ?>
                                <p class='p-2 mx-1 is-size-7-mobile'>Referee : <?php echo "{$refereename}"; ?> </p>
                            </div>
                        </div>
                        <div class='column is-narrow level-item'>
                            <?php echo "<img class='image is-96x96 m-4 my_image_maintain_aspect' src='{$awayteamlogoURL}' alt='Away Logo'>"; ?>
                        </div>
                    </div>
                </div>
                <div class='container box column is-centered my_box_border m-2 mb-5 mt-5 p-1'>
                    <div class='columns is-mobile is-vcentered is-centered'>
                        <div class='column'>
                            <h4 class='is-size-5 is-size-6-mobile has-text-right mx-3'><b> <?php echo "{$hometeam}"; ?></b>
                            </h4>
                        </div>
                        <div class='column level is-narrow m-3 mt-6 p-0'>
                            <div class='my_inline_divs result_box level-left'>
                                <p class='column is-size-5 is-size-6-mobile level-item p-1'> <?php echo "{$hometeamtotalgoals}"; ?></p>
                            </div>
                            <div class='my_inline_divs level-centre'>
                                <h4 class='level-item mx-2'>vs.</h4>
                            </div>
                            <div class='my_inline_divs result_box level-right'>
                                <p class='is-size-5 column is-size-6-mobile level-item p-1'> <?php echo "{$awayteamtotalgoals}"; ?></p>
                            </div>
                            <p class='m-2 subtitle is-6'>Full Time</p>
                        </div>
                        <div class='column'>
                            <h4 class='is-size-5 is-size-6-mobile has-text-left mx-3'><b> <?php echo "{$awayteam}"; ?><b></h4>
                        </div>
                    </div>
                </div>
                <div class='level'>
                    <?php
                        $fixtureAnalysisURL = "http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_fixture_analysis.php?fixture={$hometeam}~{$awayteam}";
                        echo "<a type='button' href='{$fixtureAnalysisURL}' class='button is-info is-rounded is-narrow level-item level-right' >Analyse this fixture</a>";
                    ?>
                </div>

                <!-- single match chart -->
                <div id='my_comparison_stat_list' class='mt-4'>
                    <div class='column' id='match_stat_chart'></div>
                </div>

                <!-- historic fixtures section -->
                <div id='my_comparison_stat_list' class='mt-6'>
                    <div class='my_info_colour'>
                        <h2 class='title is-3 pt-5 mb-2 my_info_colour'>Historic statistics.</h2>
                        <?php
                            echo "<p class='my_info_colour'>View statistics for the five prior matches between {$hometeam} and {$awayteam} </p>";
                        ?>
                        <div class='level mt-1 p-5'>
                            <p class="level-item">Select a statistic to compare :</p>
                            <div class='control has-icons-left'>
                                <div class='select is-info'>
                                    <select class=''>
                                        <option value="Goals">Goals</option>
                                        <option value="Half Time Goals">Half Time Goals</option>
                                        <option value="Shots">Shots</option>
                                        <option value="Shots On Target">Shots On Target</option>
                                        <option value="% Shots On target">% Shots On target</option>
                                        <option value="Corners">Corners</option>
                                        <option value="Fouls">Fouls</option>
                                        <option value="Yellow Cards">Yellow Cards</option>
                                        <option value="Red Cards">Red Cards</option>
                                    </select>
                                </div>
                                <div class="icon is-left">
                                    <i class="far fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                    <div>
                        <div class='column' id='former_fixtures_chart'></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <?php include('part_pages/part_site_footer.php'); ?>
    
    <script src="scripts/my_script.js"></script>
    <script>
        let matchStatChart = {
            colors: ['#48c774', '#FF6347'],
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                fontSize: '16px',
                fontFamily: 'Helvetica, Arial',
                fontWeight: 500,
                itemMargin: {
                    horizontal: 30,
                    vertical: 10
                },
                onItemHover: {
                    highlightDataSeries: false,
                },
                onItemClick: {
                    toggleDataSeries: false,
                },
            },
            series: [{
                name: <?php echo "'{$hometeam}'"; ?>,
                data: <?php print_r(json_encode($htStatsForGraph)); ?>
            }, {
                name: <?php echo "'{$awayteam}'"; ?>,
                data: <?php print_r(json_encode($atStatsForGraph)); ?>
            }],
            chart: {
                type: 'bar',
                height: 500,
                stacked: true,
                stackType: '100%',
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    top: 2,
                    left: 2,
                    blur: 3,
                    color: '#999',
                    opacity: 0.4
                },
                fontFamily: 'Helvetica, Arial, sans-serif'
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },
            },
            dataLabels: {
                enabled: true,
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: ["Half Time Goals", "Shots", "Shots on Target", "% Shots on Target", "Corners", "Fouls", "Yellow Cards", "Red Cards"],
                style: {
                    fontSize: '16px',
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            },
            fill: {
                opacity: 1
            },
        };

        var chart = new ApexCharts(document.querySelector("#match_stat_chart"), matchStatChart);
        chart.render();
    </script>
    <script>

    </script>
</body>

</html>