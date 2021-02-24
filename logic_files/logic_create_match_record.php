<!DOCTYPE html>
    <html lang='en'>

    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <script src='https://kit.fontawesome.com/06c5b011c2.js' crossorigin='anonymous'></script>
        <link rel='stylesheet' href='mystyles.css'>
        <title>EPL Match Result Entry</title>
    </head>

    <body class='has-navbar-fixed-top is-family-sans-serif'>
        <?php include("part_site_navbar.php"); ?>

        <section class='hero is-info is-bold pt-6'>
            <div class='hero-body'>
                <div class='container'>
                    <h1 class='title mt-4'>Match Entry</h1>
                </div>
            </div>
        </section>

        <div class='has-text-centered master_site_width container columns' id='my_upload_result_form'>
            <div class='column is-8 is-offset-2'>
                <div class='mt-5 p-5 my_info_colour'> 
                    <?php echo "<h2 class='subtitle is-5 my_info_colour'>{$resultString}</h2>"?>
                    <a type='button' class='my_info_colour' href='http://tkilpatrick01.lampt.eeecs.qub.ac.uk/a_assignment_code/page_add_new_result.php'> Return to previous page</a>
                </div>
            </div>
        </div>
            <?php 
                include('part_site_footer.php'); 
            ?>
        <script src='my_script.js'></script>
    </body>
    </html>
