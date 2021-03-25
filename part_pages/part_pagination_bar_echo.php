<?php
    // only show page array if there are pages to show
    // $totalMatchesToDisplay comes from part_print_summaries.php
    if ($totalMatchesToDisplay > 0) {
        echo "
            <nav class='pagination mx-1'>
            <span class='mr-3'>
                <p>Page :</p>
            </span>
            <a href='' id='previous_page_btn' class='pagination-previous is-outlined button is-info' disabled>Prev</a>
            <a href='' id='next_page_btn' class='pagination-next is-outlined button is-info'>Next</a>
            <ul class='pagination-list is-centered'>";

        // set a single control var for max page items to display on pagination bar
        $maxNumberOfPagesToDisplay = 8;
        
        require(__DIR__ . "/../logic_files/pagination_logic.php");

        if ($loadingRecentResults) {
            $totalPages = $maxNumberOfPagesToDisplay;
        } else {
            $totalPages = (int) ceil($totalMatchesToDisplay / $resultsPerPage);
        }

        if (isset($_GET['count'])) {
            $resultsPerPage = (int) htmlentities(trim($_GET['count']));
        } else {
            $resultsPerPage = 10;
        }
        $resultsQuery = "&count={$resultsPerPage}";
    
        for ($i = 1; $i <= $maxNumberOfPagesToDisplay; $i++) {       
            if ($i === $maxNumberOfPagesToDisplay) {
                $displayNumber = "...";
            } else {
                $displayNumber = $i;
            }

            if (is_numeric($displayNumber) && ($displayNumber / $resultsPerPage) === $i) {
                $buttonOutline = "";
            } else {
                $buttonOutline = "is-outlined";
            }

            $startAtValue = (($i * $resultsPerPage) - $resultsPerPage);
            $startAtQuery = "&startat={$startAtValue}";

            // remove the search params from the URL before they are set on the next click!
            if (isset($_GET['pagenumber'])) {
                unset($_GET['pagenumber']);
            }
            $currentPageURL = getCurrentPageURL();
            echo "<li><a href='?{$resultsQuery}{$startAtQuery}' class='pagination-link is-info button {$buttonOutline}'>{$displayNumber}</a></li>";
        }
        if (isset($_GET['totalresults'])) {
            unset($_GET['totalresults']);
        }
        echo "</ul></nav>"; 
    }
?>
