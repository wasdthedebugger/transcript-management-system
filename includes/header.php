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
  <link rel="stylesheet" href="styles/style.css">

  <title>TMS</title>
</head>

<body>
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="" srcset="">
    </div>
    <div class="text">
      <h1 id="school-name">Budhanilkantha School - Transcript Management System</h1>
    </div>
  </header>
  <nav>
    <div class="nav-links">
      <a class="nav-link" href="?page=home">Home</a>
      <a class="nav-link" href="?page=curriculum">Curriculum</a>
      <a class="nav-link" href="?page=students">Students</a>
      <a class="nav-link" href="?page=transcript">Transcript</a>
    </div>
    <div class="user-control-area">
      <div class="user-control">My Account</div>

      <?php if (isset($_SESSION['username'])) : ?>
        <a href="?page=logout" class="nav-link">Logout</a>
      <?php else : ?>
        <a href="?page=login" class="nav-link">Login</a>
      <?php endif; ?>

    </div>
    </div>
  </nav>