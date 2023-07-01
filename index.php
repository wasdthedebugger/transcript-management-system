<?php include("includes/header.php"); ?>

<div class="view-area">
<?php

@$page = $_GET['page'];

if($page == "") {
    $page = "home";
}

// if the page exists, include it, else show a 404 error

if(file_exists("pages/$page.php")) {
    include("pages/$page.php");
} else {
    include("404.php");
}

?>
</div>

<?php include("includes/footer.php"); ?>