<div class="level-item level-right">
    <p class="pr-3">Number of results:</p>
    <div class="field has-addons">
    <?php
            $currentPageURL = getCurrentPageURL();
            $buttonValues = array(10, 20, 30);
            
            // remove any old queries from the current URL, before adding new. 
            // means the URL cannot accumulate requests!
            if (isset($_GET['totalresults'])) {
                if (strpos($currentPageURL, "totalresults=") !== false) {
                    str_replace("totalresults=", '', $currentPageURL);
                }
            }

            for ($i = 0; $i < 3; $i++) {
                if (isset($_GET['totalresults'])) {
                    $result = (int) htmlentities(trim($_GET['totalresults']));
                } else {
                    $result = 10;
                }

                if ($buttonValues[$i] == $result) {
                    echo "
                        <p class=control>
                            <a type='button' href='{$currentPageURL}?totalresults={$buttonValues[$i]}'>
                                <p class='button is-small is-info'>{$buttonValues[$i]}</p>
                            </a>-
                        </p>";
                } else {
                    echo "
                        <p class=control>
                            <a type='button' href='{$currentPageURL}?totalresults={$buttonValues[$i]}'>
                                <p class='button is-small is-info is-outlined'>{$buttonValues[$i]}</p>
                            </a>
                        </p>";
                }
            }
        ?>
    </div>
</div>