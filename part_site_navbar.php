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
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_advanced_search.php'>Advanced Search</a>
            <a class='navbar-item my_nav_menu m-2' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_fixture_analysis.php'>Analyse Fixtures</a>
        </div>
        <div class='navbar-item'>
            <?php
                if (isset($_SESSION)) {
                    echo "<p>Logged in as {$username}</p>";
                } else {
                    echo "<a class='button is-outline is-danger' href='' type='button'>
                    <span class='icon'>
                        <i class='fas fa-user-alt'></i>
                    </span>
                    <span>Login / Register</span></a>";
                }
            ?>
        </div>
        <div class='navbar-end navbar-item has-dropdown is-hoverable pr-6'>
            <a href='' class='navbar-link'>
                <span class='material-icons p-3'>language</span>
                <span>Language</span>
            </a>
            <div class='navbar-dropdown'>
                <a class='navbar-item'>English</a>
                <a class='navbar-item'>Français</a>
                <a class='navbar-item'>Deutsche</a>
                <a class='navbar-item'>Espanol</a>
                <a class='navbar-item'>Nederlands</a>
                <a class='navbar-item'>Italiano</a>
            </div>
        </div>
    </div>
</nav>