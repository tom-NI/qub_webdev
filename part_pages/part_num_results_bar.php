<div class="level-item level-right">
    <p class="pr-3">Number of results:</p>
    <div class="field has-addons">
    <?php
        $buttonValues = array(10, 20, 30);
        $currentURL = getCurrentPageURL();

        if (isset($_GET['count'])) {
            $resultsPerPage = (int) htmlentities(trim($_GET['count']));
            $countQuery = "&count=";
            // remove any old pagination queries so the URL cannot accumulate pagination requests
            $keysArrayToStrip = array('count');
            $cleanedURL = cleanURLofPageParams($currentURL, $keysArrayToStrip);
        } else {
            $resultsPerPage = 10;
            $countQuery = "?count=";
            $cleanedURL = $currentURL;
        }

        // loop through and build buttons with dynamic link for each button
        for ($i = 0; $i < 3; $i++) {
            // display the button as outlined or not - control variable for loop below
            if ($buttonValues[$i] === $resultsPerPage) {
                $buttonOutline = "";
            } else {
                $buttonOutline = "is-outlined";
            }
            // finally print the buttons with dynamic generated links and numbers
            echo "
                <p class='control'>
                    <a href='{$cleanedURL}{$countQuery}{$buttonValues[$i]}'>
                        <span type='button' class='button is-small {$buttonOutline} is-info'>{$buttonValues[$i]}</span>
                    </a>
                </p>";
            }
        ?>
    </div>
</div>