<?php include("includes/header.php");
loggedin_only(); ?>

<!-- handle the submitted form -->

<?php
// Assuming you have a database connection established

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the submitted form data
  $firstNames = $_POST['firstName'];
  $middleNames = $_POST['middleName'];
  $lastNames = $_POST['lastName'];
  $dobs = $_POST['dob'];
  $sexes = $_POST['sex'];
  $municipalities = $_POST['municipality'];
  $districts = $_POST['district'];
  $provinces = $_POST['province'];
  $rollNos = $_POST['rollNo'];
  $joiningDates = $_POST['joiningDate'];

  // Loop through the submitted form data
  for ($i = 0; $i < count($firstNames); $i++) {
    $firstName = $firstNames[$i];
    $middleName = $middleNames[$i];
    $lastName = $lastNames[$i];
    $dob = $dobs[$i];
    $sex = $sexes[$i];
    $municipality = $municipalities[$i];
    $district = $districts[$i];
    $province = $provinces[$i];
    $rollNo = $rollNos[$i];
    $joiningDate = $joiningDates[$i];

    // Perform the database insert query
    $sql = "INSERT INTO students (first_name, middle_name, last_name, dob, sex, municipality, district, province, roll_no, joining_date) VALUES ('$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$rollNo', '$joiningDate')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
      echo "Data inserted successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }
}
?>

<div class="container mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div>
        <h2 class="text-center mb-4">Add Students</h2>

        <form action="#" method="POST">
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