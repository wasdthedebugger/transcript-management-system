<!-- nav bar bootstrap -->
<?php

// user id session
if (!isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="index.php" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
        <a class="nav-link" id="nav-tools-tab" data-bs-toggle="tab" href="tools.php" role="tab" aria-controls="nav-tools" aria-selected="false">Tools</a>
        <a class="nav-link" id="nav-about-tab" data-bs-toggle="tab" href="about.php" role="tab" aria-controls="nav-about" aria-selected="false">About</a>
        <a class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" href="contact.php" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
        <!-- login button on the right side -->
        <?php
        // if session is set then show logout button
        if (isset($_SESSION['user_id'])) {
            echo '<a class="nav-link" id="nav-logout-tab" data-bs-toggle="tab" href="logout.php" role="tab" aria-controls="nav-logout" aria-selected="false">Logout</a>';
        }
        ?>
        <div class="btn-group ml-auto" role="group">
            <a href="login.php" class="btn btn-primary">Login</a>
        </div>
    </div>
</nav>