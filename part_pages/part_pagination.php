<nav class="pagination my-2 mx-3">
    <span class="mr-3">
        <p>Go to Page :</p>
    </span>
    <a href="" id='previous_page_btn' class="pagination-previous is-outlined button is-info" disabled>Previous</a>
    <a href="" id='next_page_btn' class="pagination-next is-outlined button is-info">Next</a>
    <ul class="pagination-list is-centered">
        <!-- total results / results per page - display total as a for loop -->
        <?php           
            // only show page array if there are pages to show
            // $totalMatchesToDisplay comes from part_print_summaries (calculates total items to display)
            if ($totalMatchesToDisplay > 0) {
                if (isset($_GET['totalresults'])) {
                    $resultsPerPage = htmlentities(trim($_GET['totalresults']));
                    $totalPages = (int) ceil($totalMatchesToDisplay / $resultsPerPage);
                    
                    // limit total displayed pages to ten
                    ($totalPages > 8) ? $totalPages = 8 : $totalPages;
                    $numResultsReturnedQuery = "&count={$resultsPerPage}";
                } else {
                    $totalPages = 8;
                    $numResultsReturnedQuery = "&count=10";
                }

                if (isset($_GET['pagenumber'])) {
                    $pageNumber = (int) htmlentities(trim($_GET['pagenumber']));
                } else {
                    $pageNumber = 1;
                }
            
                if ($pageNumber > 1) {
                    if (isset($_GET['totalresults'])) {
                        $resultCount = (int) htmlentities(trim($_GET['totalresults']));
                    } else {
                        $resultCount = 10;
                    }
                    $pageQuery = "&startat{$resultCount}";
                } else {
                    $pageQuery = "&startat=0";
                }

                $currentPageURL = getCurrentPageURL();
                
                // numResultsReturnedQuery and pageQuery of these variables calculated at the top of the pages with pagination for the API request
                $newPageURL = "{$currentPageURL}{$numResultsReturnedQuery}{$pageQuery}";

                for ($i = 1; $i <= $totalPages; $i++) {
                    if (isset($pageNum)) {
                        echo "<li><a href='{$newPageURL}' class='pagination-link is-info button is-outlined'>{$i}</a></li>";
                    } elseif (!isset($pageNum)) {
                        echo "<li><a href='{$newPageURL}' class='pagination-link is-info button'>{$i}</a></li>";
                    }
                }
            }
        ?>
    </ul>
</nav>