<?php include("includes/header.php"); ?>

<!-- if logged in show stats -->
<?php if (loggedin()) { ?>
    <!-- welcome the user -->
    <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <h1>Welcome ! <?php echo(username()); ?></h1>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <p><?php echo(usertype()); ?></p>
    </div>
  </div>
</div>
    </div>
<?php } else { ?>
    <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <h1>Welcome to the TMS!</h1>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-12 text-center">
      <p>Please login to continue</p>
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

<?php include("includes/footer.php"); ?>