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

  <!-- jquery cdn -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- bootstrap cdn -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  
  <link rel="stylesheet" href="styles/style.css">

  <title>TMS</title>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">Home</a>
    <div class="navbar-toggler-wrapper d-flex justify-content-end">
      <?php if (isset($_SESSION['username'])) : ?>
        <a href="logout.php" class="btn btn-danger m-1">Logout</a>
      <?php else : ?>
        <a href="login.php" class="btn btn-primary m-1">Login</a>
      <?php endif; ?>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if (loggedin()) { ?>
          <li class="nav-item">
            <a class="nav-link" href="addstudents.php">Add Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="studentgrades.php">Grades</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="studentprofile.php">Profiles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="students.php">Manage Students</a>
          </li>
          <?php if (is_super_admin()) { ?>
            <li class="nav-item">
            <a class="nav-link" href="createuser.php">Create User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="csventry.php">CSV</a>
          </li>
        <?php }} else { ?>
          <li class="nav-item">
            Login to view more
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>




<!-- Add the following JavaScript files at the end of your HTML body -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<body>