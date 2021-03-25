<div class="level-item level-right">
    <p class="pr-3">Number of results:</p>
    <div class="field has-addons">
    <?php
        $currentPageURL = getCurrentPageURL();
        $buttonValues = array(10, 20, 30);
        
        // remove any old pagination queries from the current URL, before adding new. 
        // means the URL cannot accumulate requests!

        for ($i = 0; $i < 3; $i++) {
            if (isset($_GET['count'])) {
                $resultsPerPage = (int) htmlentities(trim($_GET['count']));
                // then remove it from the URL for the next query!
            } else {
                $resultsPerPage = 10;
            }

            // display the button as outlined or not - control variable for loop below
            if ($buttonValues[$i] === $resultsPerPage) {
                $buttonOutline = "";
            } else {
                $buttonOutline = "is-outlined";
            }
            // finally print the buttons with dynamic generated links and numbers
            echo "
                <p class='control'>
                    <a href='?count={$buttonValues[$i]}'>
                        <span type='button' class='button is-small {$buttonOutline} is-info'>{$buttonValues[$i]}</span>
                    </a>
                </p>";
            }
        ?>
    </div>
</div>