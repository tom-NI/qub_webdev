<nav class="pagination my-2 mx-3">
    <span class="mr-3">
        <p>Go to Page :</p>
    </span>
    <a href="" class="pagination-previous is-outlined button is-info" disabled>Previous</a>
    <a href="" class="pagination-next is-outlined button is-info">Next</a>
    <ul class="pagination-list is-centered">
        <!-- total results / results per page - display total as a for loop -->
        <?php
            // only show page array if there are pages to show
            if ($totalMatchesToDisplay > 0) {
                if (isset($_GET['totalresults'])) {
                    $resultsPerPage = htmlentities(trim($_GET['totalresults']));
                    $totalPages = (int) ceil($totalMatchesToDisplay / $resultsPerPage);
                } else {
                    $resultsPerPage = 10;
                }
                $totalPages = (int) ceil($totalMatchesToDisplay / $resultsPerPage);
                for ($i = 0; $i < $totalPages; $i++) {
                    if (isset($pageNum)) { // page number is something - set the button to be 
                        $pageNum = $i + 1;
                        echo "<li><a href='page_advanced_search.php?totalresults={$resultsPerPage}&pagenumber={$pageNum}&userfilter' 
                        class='pagination-link is-info button is-outlined'>{$pageNum}</a></li>";
                    } elseif (!isset($pageNum)) {
                        $pageNum = $i + 1;
                        echo "<li><a href='page_advanced_search.php?totalresults={$resultsPerPage}&pagenumber={$pageNum}&userfilter' 
                        class='pagination-link is-info button'>{$pageNum}</a></li>";
                    }
                }
            }
        ?>
    </ul>
</nav>