<?php
session_start();
include("includes/conn.php");
include("functions/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- bootstrap cdn -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <title>Document</title>
</head>

<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-link" id="nav-home-tab" href="index.php" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>


    <?php if (loggedin()) { ?>
      <!-- student grades -->
      <a class="nav-link" id="nav-studentgrades-tab" href="studentgrades.php" role="tab" aria-controls="nav-studentgrades" aria-selected="false">Student Grades</a>
      <a class="nav-link" id="nav-addstudents-tab" href="addstudents.php" role="tab" aria-controls="nav-addstudents" aria-selected="false">Add Students</a>
      <a class="nav-link" id="nav-studentprofile-tab" href="studentprofile.php" role="tab" aria-controls="nav-studentprofile" aria-selected="false">Student Profile</a>
    <?php } ?>
    <!-- if superadmin, show a create user link -->

    <?php if (is_super_admin()) : ?>
      <a class="nav-link" id="nav-createuser-tab" href="createuser.php" role="tab" aria-controls="nav-createuser" aria-selected="false">Create User</a>
    <?php endif; ?>

    <div class="btn-group ml-auto" role="group">
      <?php if (isset($_SESSION['username'])) : ?>
        <a href="logout.php" class="btn btn-danger m-1">Logout</a>
      <?php else : ?>
        <a href="login.php" class="btn btn-primary m-1">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<body>
  