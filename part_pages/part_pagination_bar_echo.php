<?php
    // only show page array if there are pages to show
    // $totalMatchesToDisplay comes from part_print_summaries.php
    if ($totalMatchesToDisplay > 0) {
        // set a single control var for max page items to display on pagination bar
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
                // only show prev button on all pages except first!
                echo "<a href='?{$previousPageQuery}' id='previous_page_btn' class='pagination-previous is-outlined button is-info'>Prev</a>";
            }
            echo "
            <a href='?{$nextPageQuery}' id='next_page_btn' class='pagination-next is-outlined button is-info'>Next</a>
            <ul class='pagination-list is-centered'>";
        
        for ($i = 1; $i <= $totalPages; $i++) {       
            if ($i === $maxNumberOfPagesToDisplay) {
                $displayNumber = "...";
            } else {
                $displayNumber = $i;
            }

            // alter page button to be solid if the user has previously selected it
            if (isset($_GET['startat']) && isset($_GET['count'])
                     && (($_GET['startat'] + $_GET['count']) / $resultsPerPage) === $i) {
                $buttonOutline = "";
            } elseif (!isset($_GET['startat']) && $i === 1) {
                $buttonOutline = "";
            } else {
                $buttonOutline = "is-outlined";
            }

            // dynamically alter the URL for each button based on the for loop
            $startAtValue = (($i * $resultsPerPage) - $resultsPerPage);
            $startAtQuery = "&startat={$startAtValue}";

            // use a cleaner function to remove existing count and startat URL parameters!
            $cleanedURL = cleanURLofPageParams(getCurrentPageURL());

            $currentPageURL = getCurrentPageURL();
            echo "<li><a href='{$cleanedURL}{$resultsQuery}{$startAtQuery}' class='pagination-link is-info button {$buttonOutline}'>{$displayNumber}</a></li>";
        }
        echo "</ul></nav>"; 
    }
?>
