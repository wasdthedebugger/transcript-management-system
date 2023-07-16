<?php

$table_name = "twelve_neb";
$standard = 1;
$system = 0;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to insert or update marks in the eleven_alevels table
    $sql = "INSERT INTO $table_name (roll_no, english, english_pr, nepali, nepali_pr, maths, maths_pr, physics, physics_pr, chemistry, chemistry_pr, computer, computer_pr, biology, biology_pr, gpa) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
            english = VALUES(english), english_pr = VALUES(english_pr), nepali = VALUES(nepali), nepali_pr = VALUES(nepali_pr), 
            maths = VALUES(maths), maths_pr = VALUES(maths_pr), physics = VALUES(physics), physics_pr = VALUES(physics_pr), 
            chemistry = VALUES(chemistry), chemistry_pr = VALUES(chemistry_pr), computer = VALUES(computer), computer_pr = VALUES(computer_pr), 
            biology = VALUES(biology), biology_pr = VALUES(biology_pr), gpa = VALUES(gpa)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Loop through the submitted form data
    foreach ($_POST['rollNumber'] as $rollNumber) {

        $english = $_POST['english'][$rollNumber];
        $english_pr = $_POST['english_pr'][$rollNumber];
        $nepali = $_POST['nepali'][$rollNumber];
        $nepali_pr = $_POST['nepali_pr'][$rollNumber];
        $maths = $_POST['maths'][$rollNumber];
        $maths_pr = $_POST['maths_pr'][$rollNumber];
        $physics = $_POST['physics'][$rollNumber];
        $physics_pr = $_POST['physics_pr'][$rollNumber];
        $chemistry = $_POST['chemistry'][$rollNumber];
        $chemistry_pr = $_POST['chemistry_pr'][$rollNumber];
        $computer = $_POST['computer'][$rollNumber];
        $computer_pr = $_POST['computer_pr'][$rollNumber];
        $biology = $_POST['biology'][$rollNumber];
        $biology_pr = $_POST['biology_pr'][$rollNumber];

        $gpa = highSchoolNebGPA($english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sddddddddddddddd", $rollNumber, $english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr, $gpa);

        // Execute the statement
        mysqli_stmt_execute($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

entryFieldsGrade($standard, $system, $table_name, $conn);
