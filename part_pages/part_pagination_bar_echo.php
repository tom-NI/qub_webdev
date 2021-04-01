<?php
    // only show page array if there are pages to show
    // $totalMatchesToDisplay comes from part_print_summaries.php
    if ($totalMatchesToDisplay > 0) {

        // remove existing pagination URL parameters from URL (to stop them accumulating)
        $keysArrayToRemoveFromURL = array('count', 'startat');
        $cleanedURL = cleanURLofPageParams(getCurrentPageURL(), $keysArrayToRemoveFromURL);

        // get the total match count for the user query and use for total page numbers
        $totalCountURL = cleanURLofPageParams($finalDataURL, $keysArrayToRemoveFromURL);
        $totalCountData = postDevKeyInHeader($totalCountURL);
        $totalCountList = json_decode($totalCountData, true);
        $totalQueryCount = count($totalCountList);

        // set a single control var for max buttons
        $maxNumberOfPagesToDisplay = 8;

        // alter the total pages if checking recent queries
        if ($loadingRecentResults) {
            $totalPages = $maxNumberOfPagesToDisplay;
        } else {
            $totalPages = (int) ceil($totalQueryCount / $resultsPerPage);
            if ($totalPages > $maxNumberOfPagesToDisplay) {
                $totalPages = $maxNumberOfPagesToDisplay;
            }
        }

        // echo out the bar
        // apply logic to the prev and next buttons specifically
        echo "
            <nav class='pagination mx-1'>
            <span class='mr-3'>
                <p>Page :</p>
            </span>";
            if (isset($_GET['startat']) && $_GET['startat'] != 0) {
                // only show prev button on all pages except first page!
                echo "<a href='{$cleanedURL}?{$previousPageQuery}' id='previous_page_btn' class='pagination-previous is-outlined button is-info'>Prev</a>";
            }
            if ($totalPages > 1) {
                echo "<a href='{$cleanedURL}?{$nextPageQuery}' id='next_page_btn' class='pagination-next is-outlined button is-info'>Next</a>
                <ul class='pagination-list is-centered'>";
            }

        // dynamically calculate current page number based on URL
        if (isset($_GET['startat']) && isset($_GET['count'])) {
            $currentPageCalculation = (($_GET['startat'] + $_GET['count']) / $resultsPerPage);
        } else {
            $currentPageCalculation = 1;
        }

        if (isset($_GET['count'])) {
            $resultsPerPage = (int) htmlentities(trim($_GET['count']));
        } else {
            $resultsPerPage = 10;
        }
        $numResultsReturnedQuery = "&count={$resultsPerPage}";

        // set initial string value for button being solid
        $buttonOutline = "is-outlined";

        // print out each page button using a loop
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i === $maxNumberOfPagesToDisplay) {
                $displayNumber = "...";
            } else {
                $displayNumber = $i;
            }

            // alter page button to be solid if the user has previously selected it
            if ($currentPageCalculation == $i || (!isset($_GET['startat']) && $i === 1)) {
                $buttonOutline = "";
            } else {
                $buttonOutline = "is-outlined";
            }

            // dynamically alter the URL and API data call for each button based on the for loop
            $startAtValue = (($i * $resultsPerPage) - $resultsPerPage);
            $startAtQuery = "&startat={$startAtValue}";

            // echo out each page button with a custom URL link for each button
            echo "<li><a href='{$cleanedURL}{$numResultsReturnedQuery}{$startAtQuery}' class='pagination-link is-info button {$buttonOutline}'>{$displayNumber}</a></li>";
        }
        echo "</ul></nav>"; 
    }
?>
