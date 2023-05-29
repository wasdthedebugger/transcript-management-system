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

        if (!isValidRollNumber($rollNo)) {
          fail('Invalid roll number format: ' . $rollNo);
          continue; // Skip this iteration and proceed to the next loop
        }

        // Perform the database insert query
        $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate')";

        // Execute the query
        try {
          mysqli_query($conn, $sql);
          success('Data inserted successfully !');
        } catch (mysqli_sql_exception $e) {
          $error = $e->getMessage();
          if (strpos($error, 'Duplicate entry') !== false) {
            fail('Duplicate entry: The data already exists in the database.');
          } else {
            fail('Error inserting data: ' . $error);
          }
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

      if (!isValidRollNumber($rollNo)) {
        fail('Invalid roll number format: ' . $rollNo);
        continue; // Skip this iteration and proceed to the next loop
      }

      // Perform the database insert query
      $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate')";

      // Execute the query
      try {
        mysqli_query($conn, $sql);
        success('Data inserted successfully !');
      } catch (mysqli_sql_exception $e) {
        $error = $e->getMessage();
        if (strpos($error, 'Duplicate entry') !== false) {
          fail("Duplicate entry: The data already exists in the database.");
        } else {
          fail('Error inserting data: ' . $error);
        }
      }
    }
  }
}

?>

<style>
  input[type="text"] {
    width: 150px;
  }
</style>

<div class="container mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-12"> <!-- Adjust the column classes to make the form wider -->
        <h1 class="text-center mb-4">Add Students</h1>

        <div class="mb-4"></div> <!-- Add spacing between the CSV file input and the form -->

        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="csvFile">Upload CSV File</label>
            <input type="file" class="form-control" id="csvFile" name="csvFile">
          </div>

          <div class="table-responsive mt-4"> <!-- Add spacing between the CSV file input and the form -->
            <table class="table table-bordered" id="student-table">
              <table class="table table-bordered" id="student-table">
                <thead>
                  <tr>
                    <th>Roll&nbsp;No</th>
                    <th>First&nbsp;Name</th>
                    <th>Middle&nbsp;Name</th>
                    <th>Last&nbsp;Name</th>
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
                    <td><input type="text" class="form-control" name="lastName[]" style="width: 150px"></td>
                    <td><input type="date" class="form-control" name="dob[]"></td>
                    <td>
                      <select class="form-select" name="sex[]">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </td>
                    <td><input type="text" class="form-control" name="municipality[]" style="width: 150px"></td>
                    <td>
                      <select class="form-select" name="district[]">
                        <option value="Achham">Achham</option>
                        <option value="Arghakhanchi">Arghakhanchi</option>
                        <option value="Baglung">Baglung</option>
                        <option value="Baitadi">Baitadi</option>
                        <option value="Bajhang">Bajhang</option>
                        <option value="Bajura">Bajura</option>
                        <option value="Banke">Banke</option>
                        <option value="Bara">Bara</option>
                        <option value="Bardiya">Bardiya</option>
                        <option value="Bhaktapur">Bhaktapur</option>
                        <option value="Bhojpur">Bhojpur</option>
                        <option value="Chitwan">Chitwan</option>
                        <option value="Dadeldhura">Dadeldhura</option>
                        <option value="Dailekh">Dailekh</option>
                        <option value="Dang">Dang</option>
                        <option value="Darchula">Darchula</option>
                        <option value="Dhading">Dhading</option>
                        <option value="Dhankuta">Dhankuta</option>
                        <option value="Dhanusa">Dhanusa</option>
                        <option value="Dolakha">Dolakha</option>
                        <option value="Dolpa">Dolpa</option>
                        <option value="Doti">Doti</option>
                        <option value="Eastern Rukum">Eastern Rukum</option>
                        <option value="Gorkha">Gorkha</option>
                        <option value="Gulmi">Gulmi</option>
                        <option value="Humla">Humla</option>
                        <option value="Ilam">Ilam</option>
                        <option value="Jajarkot">Jajarkot</option>
                        <option value="Jhapa">Jhapa</option>
                        <option value="Jumla">Jumla</option>
                        <option value="Kailali">Kailali</option>
                        <option value="Kalikot">Kalikot</option>
                        <option value="Kanchanpur">Kanchanpur</option>
                        <option value="Kapilvastu">Kapilvastu</option>
                        <option value="Kaski">Kaski</option>
                        <option value="Kathmandu">Kathmandu</option>
                        <option value="Kavrepalanchok">Kavrepalanchok</option>
                        <option value="Khotang">Khotang</option>
                        <option value="Lalitpur">Lalitpur</option>
                        <option value="Lamjung">Lamjung</option>
                        <option value="Mahottari">Mahottari</option>
                        <option value="Makwanpur">Makwanpur</option>
                        <option value="Manang">Manang</option>
                        <option value="Morang">Morang</option>
                        <option value="Mugu">Mugu</option>
                        <option value="Mustang">Mustang</option>
                        <option value="Myagdi">Myagdi</option>
                        <option value="Nawalparasi">Nawalparasi</option>
                        <option value="Nuwakot">Nuwakot</option>
                        <option value="Okhaldhunga">Okhaldhunga</option>
                        <option value="Palpa">Palpa</option>
                        <option value="Panchthar">Panchthar</option>
                        <option value="Parbat">Parbat</option>
                        <option value="Parsa">Parsa</option>
                        <option value="Pyuthan">Pyuthan</option>
                        <option value="Ramechhap">Ramechhap</option>
                        <option value="Rasuwa">Rasuwa</option>
                        <option value="Rautahat">Rautahat</option>
                        <option value="Rolpa">Rolpa</option>
                        <option value="Rukum Paschim">Rukum Paschim</option>
                        <option value="Rupandehi">Rupandehi</option>
                        <option value="Salyan">Salyan</option>
                        <option value="Sankhuwasabha">Sankhuwasabha</option>
                        <option value="Saptari">Saptari</option>
                        <option value="Sarlahi">Sarlahi</option>
                        <option value="Sindhuli">Sindhuli</option>
                        <option value="Sindhupalchok">Sindhupalchok</option>
                        <option value="Siraha">Siraha</option>
                        <option value="Solukhumbu">Solukhumbu</option>
                        <option value="Sunsari">Sunsari</option>
                        <option value="Surkhet">Surkhet</option>
                        <option value="Syangja">Syangja</option>
                        <option value="Tanahu">Tanahu</option>
                        <option value="Taplejung">Taplejung</option>
                        <option value="Terhathum">Terhathum</option>
                        <option value="Udayapur">Udayapur</option>
                        <option value="Western Rukum">Western Rukum</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select" name="province[]">
                        <option value="Province 1">Province 1</option>
                        <option value="Province 2">Province 2</option>
                        <option value="Bagmati Province">Bagmati Province</option>
                        <option value="Gandaki Province">Gandaki Province</option>
                        <option value="Province 5">Province 5</option>
                        <option value="Karnali Province">Karnali Province</option>
                        <option value="Sudurpashchim Province">Sudurpashchim Province</option>
                      </select>
                    </td>
                    <td><input type="date" class="form-control" name="joiningDate[]"></td>
                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                  </tr>
                </tbody>
              </table>
            </table>
          </div>

          <div class="text-center mt-4"> <!-- Add spacing between the form and the buttons -->
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