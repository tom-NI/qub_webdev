<?php
    include_once(__DIR__ . "/../logic_files/allfunctions.php");

    // error string to be echoed depending on multiple states
    $errorString = "
        <div id='' class='master_result_card column is-centered m-2 mb-5 mt-5 p-1'> 
            <div>
                <img src='__DIR__ . /../images/nothing_in_here.png' alt='exploded football' width='300' height='300'>
            </div>
            <div class='my-3 p-5 has-background-warning'>
                <div>
                    <h3 class='title is-5'>Sorry, theres nothing in here. </h3>
                    <p class=''>Please refine your search or select less items</p>
                </div>
            </div>
        </div>";
    
    // get the data for the query
    $recentMatchesAPIData = postDevKeyInHeader($finalDataURL);

    // only proceed if a string of data is returned, and that string has items in it!
    if (is_string($recentMatchesAPIData)) {
        $recentMatchesList = json_decode($recentMatchesAPIData, true);
        if (count($recentMatchesList) > 0) {
            // create a var for pagination!
            $totalMatchesToDisplay = count($recentMatchesList);

            // go thru each match and echo out a match summary!
            foreach ($recentMatchesList as $summary) {
                $matchID = $summary['id'];
                $matchDate = $summary['match_date'];
                $homeTeam = $summary['home_team'];
                $awayTeam = $summary['away_team'];
                $homeScore = $summary['home_score'];
                $awayScore = $summary['away_score'];
                $homeLogo = $summary['home_team_logo_URL'];
                $awayLogo = $summary['away_team_logo_URL'];

                // make the date decent looking!
                $finalMatchDate = parseDateLongFormat($matchDate);
                $urlEncodedID = urlencode($matchID);
                
                echo "
                    <a href='page_single_match_result.php?num={$urlEncodedID}'>
                        <div id='' class='master_result_card container box column is-centered my_box_border m-2 mb-5 mt-5 p-1'>
                            <div class='columns' >
                                <div class='column'>
                                    <div class='is-6 is-size-7-mobile mt-3 my_inline_divs level-item'>{$finalMatchDate}</div>
                                </div>
                            </div>
                            <div class='columns is-mobile is-vcentered is-centered'>
                                <div class='column is-2 is-hidden-mobile is-narrow'>
                                    <div class='is-pulled-right'>
                                        <img class='image is-48x48 m-1 mb-5 my_image_maintain_aspect' src='{$homeLogo}' alt='Home Logo'>
                                    </div>
                                </div>
                                <div class='column p-1'>
                                    <h4 class='is-size-6 is-size-7-mobile has-text-right is-narrow has-text-weight-semibold pb-2 ml-1'>{$homeTeam}</h4>
                                </div>
                                <div class='column level mt-3 score_box is-narrow'>
                                    <div class='my_inline_divs result_box level-left'>
                                        <p class='column is-size-5 is-size-6-mobile level-item p-1'>{$homeScore}</p>
                                    </div>
                                    <div class='my_inline_divs level-centre'>
                                        <h4 class='level-item mx-1 is-size-7-mobile'>vs.</h4>
                                    </div>
                                    <div class='my_inline_divs result_box level-right'>
                                        <p class='is-size-5 is-size-6-mobile column level-item p-1'>{$awayScore}</p>
                                    </div>
                                </div>
                                <div class='column p-1'>
                                    <h4 class='is-size-6 is-size-7-mobile has-text-left is-narrow has-text-weight-semibold pb-2 mr-1'>{$awayTeam}</h4>
                                </div>
                                <div class='column is-2 is-hidden-mobile is-narrow'>
                                    <img class='image is-48x48 m-1 mb-5 my_image_maintain_aspect'
                                        src='{$awayLogo}'
                                        alt='Away Logo'>
                                </div>
                            </div>
                        </div>
                    </a>";
                } 
            } else {
                $totalMatchesToDisplay = 0;
                echo $errorString;
            }
        } else {
            $totalMatchesToDisplay = 0;
            echo $errorString;
        }
?>