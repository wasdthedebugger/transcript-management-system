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

<style>
  .container {
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  h2 {
    text-align: center;
    margin-top: 0;
  }

  form {
    margin-top: 20px;
    margin-bottom: 20px;
  }

  select {
    padding: 10px;
  }

  input{
    padding: 10px;
    width: 90%;
  }

  .custom-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #d6dfe8;
    border: none;
    cursor: pointer;
    color: red;
  }

  .custom-button:hover {
    background-color: #b3c0d1;
  }

  .form-group{
    margin-bottom: 20px;
  }

  .form-div{
    padding: 40px;
    background-color: lightgray;
  }

  label{
    display: block;
    margin-bottom: 10px;
  }
</style>

<div class="container">
    <div class="form-div">
      <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Login to TMS</div>
      <form action="#" method="POST">
        <div class="form-group">
          <label for="email">Username</label>
          <input type="email" name="email" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <div>
          <button type="submit" name="submit" class="custom-button">Login</button>
          <a class="custom-button" href="msauth">Microsoft Login</a>
        </div>
      </form>
    </div>
</div>