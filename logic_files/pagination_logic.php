<?php
    // this section of code used to get the params from URL
    // then load the correct amount of data on paginated webpages
    if (isset($_GET['count'])) {
        $resultsPerPage = (int) htmlentities(trim($_GET['count']));
    } else {
        $resultsPerPage = 10;
    }
    $numResultsReturnedQuery = "&count={$resultsPerPage}";

    if (isset($_GET['startat'])) {
        $startAtValue = (int) htmlentities(trim($_GET['startat']));
    } else {
        $startAtValue = 0;
    }
    $numResultsReturnedQuery .= "&startat={$startAtValue}";
?>