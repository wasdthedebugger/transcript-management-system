<?php include("includes/header.php");
superadmin_only(); ?>

<?php
// if submitted, create a new user, should be unique, also, the type of user also must be selected
if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $type = $_POST['user-type'];

  // check if username already exists
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
?>

    <!-- already exists banner -->
    <div class="alert alert-danger" role="alert">
      Username already exists!
    </div>

  <?php
    exit();
  }

  // check if email already exists
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  ?>
    <div class="alert alert-danger" role="alert">
      Email already exists !
    </div>
  <?php
    exit();
  }

  // create the user
  $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$username', '$email', '$password', '$type')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
  ?>
    <!-- success banner -->
    <div class="alert alert-success" role="alert">
      User created successfully
    </div>
  <?php
  } else {
  ?>
    <div class="alert alert-danger" role="alert">
      Task failed !
    </div>
<?php
  }
}
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <h1 class="text-center mb-5">Create User</h1>
      <form action="#" method="post" class="border p-4">
        <!-- username -->
        <div class="form-group">
          <label for="username">Username</label>
          <input name="username" type="text" class="form-control" id="username" placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="email">Email address</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="user-type">User Type</label>
          <select class="form-control" id="user-type" name="user-type">
            <option value="super_admin">Super Admin</option>
            <option value="teacher">Teacher</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Create User</button>
      </form>
      <br>
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</div>


<?php include("includes/footer.php"); ?>