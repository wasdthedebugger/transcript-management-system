<?php include("includes/header.php"); ?>

<body>
    <!-- if logged in show stats -->
    <?php if (loggedin()) { ?>
        <!-- welcome the user -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1><?php echo "Welcome " . username() . " !"; ?> </h1>
                    <!-- show their power -->
                    <?php
                    echo usertype();
                    ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container mt-5">

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1>Welcome to TMS !</h1>
                    <h2>Login to continue</h2>
                </div>
            </div>

        </div>
    <?php
    }
    ?>

    <?php
    if (is_super_admin()) {
        include("includes/stats.php");
    }
    ?>

</body>
<?php include("includes/footer.php"); ?>

</html>