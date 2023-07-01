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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
            <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Enter your credentials</div>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div style="text-align: center;">
                        <button type="submit" name="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
