<?php
loggedin_only();

// Assuming you have a database connection established
// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Handle the manually entered form data
  $rollNo = $_POST['rollNo'];
  $firstName = $_POST['firstName'];
  $middleName = $_POST['middleName'];
  $lastName = $_POST['lastName'];
  $dob = $_POST['dob'];
  $sex = $_POST['sex'];
  $municipality = $_POST['municipality'];
  $district = $_POST['district'];
  $province = $_POST['province'];
  $joiningDate = $_POST['joiningDate'];
  $schoolSystem = $_POST['schoolSystem'];
  $highSchoolSystem = $_POST['highSchoolSystem'];
  $standardTest = $_POST['standardTest'];

  if (!isValidRollNumber($rollNo)) {
    fail('Invalid roll number format: ' . $rollNo);
  } else {
    // Calculate the batch based on the roll number
    $batch = substr($rollNo, 0, 1) . '000' . substr($rollNo, -1);

    // Perform the database insert query
    $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date, school_system, high_school_system, standard_test, batch) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate', '$schoolSystem', '$highSchoolSystem', '$standardTest', '$batch')";

    // Execute the query
    try {
      mysqli_query($conn, $sql);
      success('Data inserted successfully!');
    } catch (mysqli_sql_exception $e) {
      $error = $e->getMessage();
      if (strpos($error, 'Duplicate entry') !== false) {
        fail('Duplicate entry: The data already exists in the database.');
      } else {
        fail('Error inserting data: ' . $error);
      }
    }
  }
}
?>

<style>
  .form-container {
    margin: 0 auto;
    padding: 20px;
  }

  .form-group {
    margin-bottom: 10px;
  }

  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  input {
    width: 92%;
  }

  .form-group input[type="text"],
  .form-group select {
    padding: 10px;
  }

  .form-group input[type="date"] {
    padding: 10px;
  }
</style>

<div class="form-container">

  <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;"> <a href=# onclick="toggleGetParameter('addstudents', 'true')">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z" />
      </svg>
    </a>Add Students</div>

  <form action="#" method="POST" enctype="multipart/form-data">

    <div class="form-group">
      <label for="rollNo">Roll No</label>
      <input type="text" id="rollNo" name="rollNo">
    </div>

    <div class="form-group">
      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName">
    </div>

    <div class="form-group">
      <label for="middleName">Middle Name</label>
      <input type="text" id="middleName" name="middleName">
    </div>

    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName">
    </div>

    <div class="form-group">
      <label for="dob">DOB</label>
      <input type="date" id="dob" name="dob">
    </div>

    <div class="form-group">
      <label for="sex">Sex</label>
      <select id="sex" name="sex">
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
    </div>

    <div class="form-group">
      <label for="municipality">Municipality</label>
      <input type="text" id="municipality" name="municipality">
    </div>

    <div class="form-group">
      <label for="district">District</label>
      <select id="district" name="district">
        <option value="Achham">Achham</option>
        <option value="Arghakhanchi">Arghakhanchi</option>
        <!-- Rest of the options... -->
      </select>
    </div>

    <div class="form-group">
      <label for="province">Province</label>
      <select id="province" name="province">
        <option value="Province 1">Province 1</option>
        <option value="Province 2">Province 2</option>
        <!-- Rest of the options... -->
      </select>
    </div>

    <div class="form-group">
      <label for="joiningDate">Joining Date</label>
      <input type="date" id="joiningDate" name="joiningDate">
    </div>

    <div class="form-group">
      <label for="schoolSystem">School System</label>
      <select id="schoolSystem" name="schoolSystem">
        <option value="neb">NEB</option>
      </select>
    </div>

    <div class="form-group">
      <label for="highSchoolSystem">High School System</label>
      <select id="highSchoolSystem" name="highSchoolSystem">
        <option value="neb">NEB</option>
        <option value="alevels">A Levels</option>
      </select>
    </div>

    <div class="form-group">
      <label for="standardTest">Standard Test</label>
      <select id="standardTest" name="standardTest">
        <option value="none">None</option>
        <option value="sat">SAT</option>
      </select>
    </div>

    <div>
      <button type="submit" class="custom-button">Submit</button>
    </div>
  </form>
</div>
