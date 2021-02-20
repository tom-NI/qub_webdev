<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
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

    <div class="columns is-desktop master_site_width">
        <div class="columns">
            <form class='form control' method="POST" action="" >
                <div class="field">
                    <label class='label' for="">Enter email address</label>
                    <div class="input">
                        <input class='input' required type="text" name="user_email">
                    </div>
                </div>
                <div class="field">
                    <label class='label' for="">Enter Password</label>
                    <div class="input">
                        <input class='input' required type="password" name="user_password">
                    </div>
                </div>
                <div>
                    <button class='button is-danger'>Sign in</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>