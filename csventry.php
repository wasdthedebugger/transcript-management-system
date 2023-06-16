<?php
include("includes/header.php");
loggedin_only();

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
        $schoolSystem = strtoupper($data[10]);
        $highSchoolSystem = strtoupper($data[11]);
        $standardTest = strtoupper($data[12]);

        if (!isValidRollNumber($rollNo)) {
          fail('Invalid roll number format: ' . $rollNo);
          continue; // Skip this iteration and proceed to the next loop
        }

        // Calculate the batch based on the roll number
        $batch = substr($rollNo, 0, 1) . '000' . substr($rollNo, -1);

        // Perform the database insert query
        $sql = "INSERT INTO students (roll_no, first_name, middle_name, last_name, dob, sex, municipality, district, province, joining_date, school_system, high_school_system, standard_test, batch) VALUES ('$rollNo', '$firstName', '$middleName', '$lastName', '$dob', '$sex', '$municipality', '$district', '$province', '$joiningDate', '$schoolSystem', '$highSchoolSystem', '$standardTest', '$batch')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
          fail('Error executing query: ' . mysqli_error($conn));
        }


        if ($schoolSystem == "NEB") {
          $nine_neb = array();
          for ($i = 13; $i <= 22; $i++) {
            $nine_neb[] = $data[$i];
          }
          $nine_neb = array_map('getNumericGradeNEB', $nine_neb);
          $gpa = calculateSchoolNebGpa($nine_neb);

          // Prepare the SQL statement to insert or update marks in the nine_neb table
          $sql = "INSERT INTO nine_neb (roll_no, nepali, english, maths, science, social, hpe, omaths, computer, economics, geography, gpa) VALUES ('$rollNo', '$nine_neb[0]', '$nine_neb[1]', '$nine_neb[2]', '$nine_neb[3]', '$nine_neb[4]', '$nine_neb[5]', '$nine_neb[6]', '$nine_neb[7]', '$nine_neb[8]', '$nine_neb[9]', '$gpa')";
          $result = mysqli_query($conn, $sql);

          if (!$result) {
            fail('Error executing query: ' . mysqli_error($conn));
          }
          $ten_neb = array();
          for ($i = 23; $i <= 32; $i++) {
            $ten_neb[] = $data[$i];
          }
          $ten_neb = array_map('getNumericGradeNEB', $ten_neb);
          $gpa = calculateSchoolNebGpa($ten_neb);

          // Prepare the SQL statement to insert or update marks in the nine_neb table
          $sql = "INSERT INTO ten_neb (roll_no, nepali, english, maths, science, social, hpe, omaths, computer, economics, geography, gpa) VALUES ('$rollNo', '$ten_neb[0]', '$ten_neb[1]', '$ten_neb[2]', '$ten_neb[3]', '$ten_neb[4]', '$ten_neb[5]', '$ten_neb[6]', '$ten_neb[7]', '$ten_neb[8]', '$ten_neb[9]', '$gpa')";
          $result = mysqli_query($conn, $sql);

          if (!$result) {
            fail('Error executing query: ' . mysqli_error($conn));
          }
        }

        if ($highSchoolSystem == "NEB") {
          $eleven_neb = array();
          for ($i = 33; $i <= 46; $i++) {
            $eleven_neb[] = $data[$i];
          }
          $eleven_neb = array_map('getNumericGradeNEB', $eleven_neb);
          $gpa = 4;


          // Prepare the SQL statement to insert or update marks in the nine_neb table
          $sql = "INSERT INTO eleven_neb (roll_no, english, english_pr, nepali, nepali_pr, maths, maths_pr, physics, physics_pr, chemistry, chemistry_pr, computer, computer_pr, biology, biology_pr, gpa) 
        VALUES ('$rollNo', '$eleven_neb[0]', '$eleven_neb[1]', '$eleven_neb[2]', '$eleven_neb[3]', '$eleven_neb[4]', '$eleven_neb[5]', '$eleven_neb[6]', '$eleven_neb[7]', '$eleven_neb[8]', '$eleven_neb[9]', '$eleven_neb[10]', '$eleven_neb[11]', '$eleven_neb[12]', '$eleven_neb[13]', '$gpa')";
          $result = mysqli_query($conn, $sql);

          if (!$result) {
            fail('Error executing query: ' . mysqli_error($conn));
          }
          $twelve_neb = array();
          for ($i = 47; $i <= 60; $i++) {
            $twelve_neb[] = $data[$i];
          }
          $twelve_neb = array_map('getNumericGradeNEB', $twelve_neb);
          $gpa = 4;

          // Prepare the SQL statement to insert or update marks in the nine_neb table
          $sql = "INSERT INTO twelve_neb (roll_no, english, english_pr, nepali, nepali_pr, maths, maths_pr, physics, physics_pr, chemistry, chemistry_pr, computer, computer_pr, biology, biology_pr, gpa) 
        VALUES ('$rollNo', '$twelve_neb[0]', '$twelve_neb[1]', '$twelve_neb[2]', '$twelve_neb[3]', '$twelve_neb[4]', '$twelve_neb[5]', '$twelve_neb[6]', '$twelve_neb[7]', '$twelve_neb[8]', '$twelve_neb[9]', '$twelve_neb[10]', '$twelve_neb[11]', '$twelve_neb[12]', '$twelve_neb[13]', '$gpa')";

          $result = mysqli_query($conn, $sql);
          if (!$result) {
            fail('Error executing query: ' . mysqli_error($conn));
          }
        } else if ($highSchoolSystem == "ALEVELS") {

          $alevels = array();
          for ($i = 61; $i <= 71; $i++) {
            $alevels[] = $data[$i];
          }

          $alevels = array_map('getNumericGradeAlevels', $alevels);
          $gpa = 4;

          $sql = "INSERT INTO aggregate_alevels (roll_no, elang, general_paper, maths, physics, chemistry, business, economics, further_maths, biology, computer, accounting, gpa) VALUES ('$rollNo', '$alevels[0]', '$alevels[1]', '$alevels[2]', '$alevels[3]', '$alevels[4]', '$alevels[5]', '$alevels[6]', '$alevels[7]', '$alevels[8]', '$alevels[9]', '$alevels[10]', '$gpa')";

          $result = mysqli_query($conn, $sql);
          if (!$result) {
            fail('Error executing query: ' . mysqli_error($conn));
          }
        }
      }

      if ($standardTest == "SAT") {
        $score = 1200;
        $sql = "INSERT into sat (roll_no, score) VALUES ('$rollNo', '$score')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
          fail('Error executing query: ' . mysqli_error($conn));
        }
      }

      fclose($handle);
    } else {
      fail('Error opening file!');
    }
  }
}
?>

<div class="container mt-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-12"> <!-- Adjust the column classes to make the form wider -->
        <h1 class="text-center mb-4">Add Students</h1>
        <p>CSV format: Roll No,First Name,Middle Name,Last Name,DOB,Sex,Municipality,District,Province,Joining Date,School System,High School System,Standard Test</p>

        <div class="mb-4"></div> <!-- Add spacing between the CSV file input and the form -->

        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="csvFile">Upload CSV File</label>
            <input type="file" class="form-control" id="csvFile" name="csvFile">
          </div>
          <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>