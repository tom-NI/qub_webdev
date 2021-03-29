<nav class='navbar is-fixed-top is-info' role='navigation'>
    <div class='navbar-brand'>

        <div class='my_image_maintain_aspect'>
            <img id='my_site_logo'
                src='https://i.imgur.com/5kmYxaP.png'
                alt='Premier League Logo' class='image navbar-item mt-3 mx-4'>
        </div>
        <a role='button' id='nav_burger' class='navbar-burger' aria-label='menu' aria-expanded='false'>
            <span aria-hidden='true'></span>
            <span aria-hidden='true'></span>
            <span aria-hidden='true'></span>
        </a>
    </div>
    <div class='navbar-menu'>
        <div class='navbar-start'>
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/index.php'>Home</a>
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_advanced_search.php'>Match Search</a>
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_fixture_analysis.php'>Analyse Fixtures</a>
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_chart_season.php'>Chart Season Stats</a>
            <?php
                if (isset($_SESSION['sessiontype']) && strlen($_SESSION['sessiontype']) > 0) {
                    if ($_SESSION['sessiontype'] == "admin") {
                        echo "<a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/admin_cms/manage_data.php'>Manage Data</a>";
                        echo "<a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/add_data.php'>Add Data</a>";
                    } elseif ($_SESSION['sessiontype'] == "user") {
                        echo "<a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/add_data.php'>Add Result</a>";
                    }
                }
            ?>
        </div>
        <div class='navbar-end navbar-item pr-6'>
            <?php
                if (isset($_SESSION['sessiontype']) && strlen($_SESSION['sessiontype']) > 0) {
                    $username = $_SESSION['username'];
                    if ($_SESSION['sessiontype'] == "admin") {
                        echo "<p class='mx-5 m-2'>Admin - Signed in as {$username}</p>";
                    } else {
                        echo "<p class='mx-5 m-2'>Signed in as {$username}</p>";
                    }

                    // logout button (goes to a seperate php logout script)
                    echo "
                    <form action='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/logic_files/logout_logic.php?logout' method='POST'>
                        <button class='button is-outline is-danger' type='submit'>
                            <span class='icon'>
                                <i class='fas fa-sign-out-alt'></i>
                            </span>
                            <span>Logout</span>
                        </button>
                    </form>";
                } else {
                    echo "<a class='button is-outline is-danger' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/login.php' type='button'>
                        <span class='icon'>
                            <i class='fas fa-user-alt'></i>
                        </span>
                    <span>User Login</span></a>";
                }
            ?>
        </div>
    </div>
</nav>