<?php
superadmin_only(); ?>

<?php
// if submitted, create a new user, should be unique, also, the type of user also must be selected
if (isset($_POST['email'])) {
  $email = $_POST['email'];
  $type = $_POST['user-type'];

  // check if username already exists
  $sql = "SELECT * FROM msauth WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
?>

    <!-- already exists banner -->
    <div class="alert alert-danger" role="alert">
      Email already exists !
    </div>

  <?php
    exit();
  }

  // check if email already exists
  $sql = "SELECT * FROM msauth WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
  ?>
    <div class="alert alert-danger" role="alert">
      Email already exists !
    </div>
  <?php
  }

  // create the user
  $sql = "INSERT INTO msauth (email, user_type) VALUES ('$email', '$type')";
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
      <h1 class="text-center mb-5">Add Users</h1>
      <form action="#" method="post" class="border p-4">


        <div class="form-group">
          <label for="email">Email address</label>
          <input name="email" type="email" class="form-control" id="email" placeholder="Enter email">
        </div>

        <div class="form-group">
          <label for="user-type">User Type</label>
          <select class="form-control" id="user-type" name="user-type">
            <option value="super_admin">Super Admin</option>
            <option value="teacher">Teacher</option>
          </select>
        </div>
        <button type="submit" class="custom-button" name="submit">Create User</button>
      </form>
    </div>
  </div>
</div>

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

  input {
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

  .form-group {
    margin-bottom: 20px;
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
</style>

<?php include("includes/footer.php"); ?>