<?php
    // this section of code used to get the params from URL
    // then load the correct amount of data on paginated webpages
    if (isset($_GET['count'])) {
        $resultsPerPage = (int) htmlentities(trim($_GET['count']));
    } else {
        $resultsPerPage = 10;
    }
    $numResultsReturnedQuery = "&count={$resultsPerPage}";

    // now finalise the starting point query
    if (isset($_GET['startat'])) {
        $startAtValue = (int) htmlentities(trim($_GET['startat']));
    } else {
        $startAtValue = 0;
    }

    //build the "next page" and "prev page" button links queries
    if ($startAtValue >= $resultsPerPage) {
        $previousStartAtValue = $startAtValue - $resultsPerPage;
    } else {
        $previousStartAtValue = 0;
    }
    $nextStartAtValue = $resultsPerPage + $startAtValue;
    $previousPageQuery = "{$numResultsReturnedQuery}&startat={$previousStartAtValue}";
    $nextPageQuery = "{$numResultsReturnedQuery}&startat={$nextStartAtValue}";

    // then set the final page query for count and startat for each individual page button
    $numResultsReturnedQuery .= "&startat={$startAtValue}";
?>