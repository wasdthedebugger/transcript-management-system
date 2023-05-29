<?php include("includes/header.php"); ?>

<?php

// if logged in redirect to index.php
if (loggedin()) {
  header("Location: index.php");
}

if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // check if user exists
  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    // user exists
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['user_type'] = $row['user_type'];
    header("Location: index.php");
  } else {
    fail("Invalid email or password");
  }
}

?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <form action="#" method="POST">
        <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary" name="submit"">Login</button>
      </form>
    </div>
    
  </div>
</div>

<?php include("includes/footer.php"); ?>