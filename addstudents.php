<?php
include("includes/header.php");
loggedin_only();

// Assuming you have a database connection established

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if CSV file is uploaded
  if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
    $csvFilePath = $_FILES['csvFile']['tmp_name'];

    // Process the CSV file and insert data into the database
    if (($handle = fopen($csvFilePath, 'r')) !== false) {
      // Skip the header row
      fgetcsv($handle);

      // Loop through the rows in the CSV file
      while (($data = fgetcsv($handle)) !== false) {
        // Extract the data from each row
        $rollNo = $data[0];
        $firstName = $data[1];
        $middleName = $data[2];
        $lastName = $data[3];
        $dob = $data[4];
        $sex = $data[5];
        $municipality = $data[6];
        $district = $data[7];
        $province = $data[8];
        $joiningDate = $data[9];

        // Perform the database insert query
        $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
          success('Data inserted successfully !');
        } else {
          fail('Error inserting data !');
        }
      }

      fclose($handle);
    } else {
      fail('Error opening file !');
    }
  } else {
    // Handle the manually entered form data
    $rollNos = $_POST['rollNo'];
    $firstNames = $_POST['firstName'];
    $middleNames = $_POST['middleName'];
    $lastNames = $_POST['lastName'];
    $dobs = $_POST['dob'];
    $sexes = $_POST['sex'];
    $municipalities = $_POST['municipality'];
    $districts = $_POST['district'];
    $provinces = $_POST['province'];
    $joiningDates = $_POST['joiningDate'];

    // Loop through the submitted form data
    for ($i = 0; $i < count($rollNos); $i++) {
      $rollNo = $rollNos[$i];
      $firstName = $firstNames[$i];
      $middleName = $middleNames[$i];
      $lastName = $lastNames[$i];
      $dob = $dobs[$i];
      $sex = $sexes[$i];
      $municipality = $municipalities[$i];
      $district = $districts[$i];
      $province = $provinces[$i];
      $joiningDate = $joiningDates[$i];

      // Perform the database insert query
      $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate')";

      // Execute the query
      if (mysqli_query($conn, $sql)) {
        success('Data inserted successfully !')
      } else {
        fail('Error inserting data !');
      }
    }
  }
}
?>

<div class="container mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div>
        <h2 class="text-center mb-4">Add Students</h2>

        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="csvFile">Upload CSV File</label>
            <input type="file" class="form-control" id="csvFile" name="csvFile">
          </div>

          <div class="table-responsive">
            <table class="table table-bordered" id="student-table">
              <thead>
                <tr>
                  <th>Roll No</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>DOB</th>
                  <th>Sex</th>
                  <th>Municipality</th>
                  <th>District</th>
                  <th>Province</th>
                  <th>Joining Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" class="form-control" name="rollNo[]"></td>
                  <td><input type="text" class="form-control" name="firstName[]"></td>
                  <td><input type="text" class="form-control" name="middleName[]"></td>
                  <td><input type="text" class="form-control" name="lastName[]"></td>
                  <td><input type="date" class="form-control" name="dob[]"></td>
                  <td>
                    <select class="form-select" name="sex[]">
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </td>
                  <td><input type="text" class="form-control" name="municipality[]"></td>
                  <td>
                    <select class="form-select" name="district[]">
                      <option value="">Select district</option>
                      <option value="Kathmandu">Kathmandu</option>
                      <!-- Add options for districts -->
                    </select>
                  </td>
                  <td>
                    <select class="form-select" name="province[]">
                      <option value="">Select province</option>
                      <option value="Bagmati">Bagmati</option>
                      <!-- Add options for provinces -->
                    </select>
                  </td>
                  <td><input type="date" class="form-control" name="joiningDate[]"></td>
                  <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="text-center">
            <button type="button" class="btn btn-primary" id="add-row">Add Row</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Delete row when the delete button is clicked
    $(document).on('click', '.delete-row', function() {
      var rowCount = $('#student-table tbody tr').length;
      if (rowCount > 1) {
        $(this).closest('tr').remove();
      } else {
        alert('At least one row must remain.');
      }
    });

    // Add new row when the add row button is clicked
    $('#add-row').click(function() {
      var newRow = '<tr>' +
        '<td><input type="text" class="form-control" name="rollNo[]"></td>' +
        '<td><input type="text" class="form-control" name="firstName[]"></td>' +
        '<td><input type="text" class="form-control" name="middleName[]"></td>' +
        '<td><input type="text" class="form-control" name="lastName[]"></td>' +
        '<td><input type="date" class="form-control" name="dob[]"></td>' +
        '<td><select class="form-select" name="sex[]"><option value="male">Male</option><option value="female">Female</option></select></td>' +
        '<td><input type="text" class="form-control" name="municipality[]"></td>' +
        '<td><select class="form-select" name="district[]"><option value="">Select district</option><!-- Add options for districts --></select></td>' +
        '<td><select class="form-select" name="province[]"><option value="">Select province</option><!-- Add options for provinces --></select></td>' +
        '<td><input type="date" class="form-control" name="joiningDate[]"></td>' +
        '<td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>' +
        '</tr>';
      $('#student-table tbody').append(newRow);
    });
  });
</script>

<?php include("includes/footer.php"); ?>