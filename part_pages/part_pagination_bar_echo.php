<?php
    // only show page array if there are pages to show
    // $totalMatchesToDisplay comes from part_print_summaries.php
    if ($totalMatchesToDisplay > 0) {

        // set a single control var for max buttons
        $maxNumberOfPagesToDisplay = 8;
        
        // load modularized pagination logic!
        require(__DIR__ . "/../logic_files/pagination_logic.php");

        // alter the total pages if checking recent queries
        if ($loadingRecentResults) {
            $totalPages = $maxNumberOfPagesToDisplay;
        } else {
            $totalPages = (int) ceil($totalQueryCount / $resultsPerPage);
            if ($totalPages > $maxNumberOfPagesToDisplay) {
                $totalPages = $maxNumberOfPagesToDisplay;
            }
        }

        if (isset($_GET['count'])) {
            $resultsPerPage = (int) htmlentities(trim($_GET['count']));
        } else {
            $resultsPerPage = 10;
        }
        $resultsQuery = "count={$resultsPerPage}";

        echo "
            <nav class='pagination mx-1'>
            <span class='mr-3'>
                <p>Page :</p>
            </span>";
            if (isset($_GET['startat']) && $_GET['startat'] != 0) {
                // only show prev button on all pages except first page!
                echo "<a href='?{$previousPageQuery}' id='previous_page_btn' class='pagination-previous is-outlined button is-info'>Prev</a>";
            }
            echo "
            <a href='?{$nextPageQuery}' id='next_page_btn' class='pagination-next is-outlined button is-info'>Next</a>
            <ul class='pagination-list is-centered'>";
        
        // remove existing pagination URL parameters from URL (to stop them accumulating)
        $cleanedURL = cleanURLofPageParams(getCurrentPageURL());

        // set current page calc based on URL
        if (isset($_GET['startat']) && isset($_GET['count'])) {
            $currentPageCalculation = (($_GET['startat'] + $_GET['count']) / $resultsPerPage);
        } else {
            $currentPageCalculation = 1;
        }

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

            // dynamically alter the URL for each button based on the for loop
            $startAtValue = (($i * $resultsPerPage) - $resultsPerPage);
            $startAtQuery = "&startat={$startAtValue}";

            // finally, echo out each page button with a custom URL link for each button
            echo "<li><a href='{$cleanedURL}{$resultsQuery}{$startAtQuery}' class='pagination-link is-info button {$buttonOutline}'>{$displayNumber}</a></li>";
        }
        echo "</ul></nav>"; 
    }
?>
