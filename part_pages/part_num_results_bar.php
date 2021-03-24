<div class="level-item level-right">
    <p class="pr-3">Number of results:</p>
    <div class="field has-addons">
    <?php
            $currentPageURL = getCurrentPageURL();
            $buttonValues = array(10, 25, 50);

            for ($i = 0; $i < 3; $i++) {
                if (isset($_GET['totalresults'])) {
                    $result = $_GET['totalresults'];
                    if ($buttonValues[$i] === $result) {
                        echo "
                            <p class=control>
                                <button action='$currentPageURL' name='totalresults' value='{$buttonValues[$i]}' method='GET' class='button is-small is-info is-outlined'>
                                    <p>{$buttonValues[$i]}</p>
                                </button>
                            </p>";
                    } else {
                        echo "
                            <p class=control>
                                <button action='$currentPageURL' name='totalresults' value='{$buttonValues[$i]}' method='GET' class='button is-small is-info'>
                                    <p>{$buttonValues[$i]}</p>
                                </button>
                            </p>";
                    }
                }
            }
        ?>
    </div>
</div>