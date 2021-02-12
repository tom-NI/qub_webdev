<?php
    // site navigation bar, common to all pages
    echo
    "<nav class='navbar is-fixed-top is-info' role='navigation'>
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
                <a class='navbar-item my_nav_menu m-2' href='index.php'>Home</a>
                <a class='navbar-item my_nav_menu m-2' href='page_fixture_analysis.php'>Analyse Fixtures</a>
                <a class='navbar-item my_nav_menu m-2' href='page_advanced_search.php'>Advanced Search</a>
                <a class='navbar-item my_nav_menu m-2' href='page_add_new_result.php'>Add Results</a>
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
    </nav>"

?>