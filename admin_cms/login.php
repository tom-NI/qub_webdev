<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/06c5b011c2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../mystyles.css">
    <title>epl - Login / Register</title>
</head>
<body class="has-navbar-fixed-top is-family-sans-serif">
    <!-- Full nav bar -->
    <?php include("../part_site_navbar.php"); ?>

    <!-- banner at the top of the page! -->
    <section class="hero is-info is-bold pt-6">
        <div class="hero-body">
            <div class="container">
                <h1 class="title mt-4">User Login</h1>
            </div>
        </div>
    </section>

    <div class="columns is-desktop master_site_width mt-6 ">
        <div class="column is-6 is-offset-3 my_grey_highlight_para">
            <h2 class='title is-4 pt-4'>Sign In:</h2>
            <form class='form control' method="POST" action="" >
                <div class="field">
                    <label class='label mt-3 has-text-left' for="">Email address:</label>
                    <div class="control">
                        <input class='input has-text-left' required type="text" placeholder='email@email.com' name="user_email">
                    </div>
                </div>
                <div class="field mt-3">
                    <label class='label has-text-left' for="">Password:</label>
                    <div class="control">
                        <input class='input has-text-left' required type="password" placeholder='password' name="user_password">
                    </div>
                </div>
                <div class="">
                    <button class='button is-danger m-3'>Sign in</button>
                </div>
            </form>
        </div>
    </div>
    <?php include("../part_site_footer.php"); ?>
    
</body>
</html>