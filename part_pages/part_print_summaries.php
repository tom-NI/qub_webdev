<?php
    include_once(__DIR__ . "/../logic_files/allfunctions.php");
    // get the total for this query for page numbering, without getting the data
    // $queryDataWithoutPagination = postDevKeyInHeader($finalTotalPagesCountURL);
    // $allDataAsJSON = json_decode($queryDataWithoutPagination, true);
    // $totalMatchesToDisplay = (int) count($allDataAsJSON);
    // print_r($totalMatchesToDisplay);
    
    // get the data for the query
    $recentMatchesAPIData = postDevKeyInHeader($finalDataURL);
    $recentMatchesList = json_decode($recentMatchesAPIData, true);

    foreach ($recentMatchesList as $summary) {
        $matchID = $summary['id'];
        $matchDate = $summary['matchdate'];
        $homeTeam = $summary['hometeam'];
        $awayTeam = $summary['awayteam'];
        $homeScore = $summary['homescore'];
        $awayScore = $summary['awayscore'];
        $homeLogo = $summary['hometeamlogoURL'];
        $awayLogo = $summary['awayteamlogoURL'];

        // make the date decent looking!
        $finalMatchDate = parseDateLongFormat($matchDate);

        echo "
        <a href='page_single_match_result.php?id={$matchID}'>
                <div id='' class='master_result_card container box column is-centered my_box_border m-2 mb-5 mt-5 p-1'>
                    <div class='columns' >
                        <div class='column'>
                            <div class='is-size-6 mt-3 is-size-7-mobile my_inline_divs level-item'>{$finalMatchDate}</div>
                        </div>
                    </div>
                    <div class='columns is-mobile is-vcentered is-centered'>
                        <div class='column is-2 is-hidden-mobile is-narrow'>
                            <div class='is-pulled-right'>
                                <img class='image is-48x48 m-1 mb-5 my_image_maintain_aspect' src='{$homeLogo}' alt='Home Logo'>
                            </div>
                        </div>
                        <div class='column'>
                            <h4 class='is-size-6 is-size-6-mobile has-text-right is-narrow'>
                                <b>{$homeTeam}</b>
                            </h4>
                        </div>
                        <div class='column level mt-4 is-narrow'>
                            <div class='my_inline_divs result_box level-left'>
                                <p class='column is-size-5 is-size-6-mobile level-item p-1'>{$homeScore}</p>
                            </div>
                            <div class='my_inline_divs level-centre'>
                                <h4 class='level-item mx-2 is-size-7-mobile'>vs.</h4>
                            </div>
                            <div class='my_inline_divs result_box level-right'>
                                <p class='is-size-5 is-size-6-mobile column level-item p-1'>{$awayScore}</p>
                            </div>
                        </div>
                        <div class='column'>
                            <h4 class='is-size-6 is-size-6-mobile has-text-left is-narrow'>
                                <b>{$awayTeam}</b>
                            </h4>
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
?>