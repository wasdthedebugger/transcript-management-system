<?php

$table_name = "aggregate_alevels";
$standard = 1;
$system = 1;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to insert or update marks in the nine_neb table
    $sql = "INSERT INTO $table_name (roll_no, elang, general_paper, maths, physics, chemistry, business, economics, further_maths, biology, computer, accounting, gpa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE elang = VALUES(elang), general_paper = VALUES(general_paper), maths = VALUES(maths), physics = VALUES(physics), chemistry = VALUES(chemistry), business = VALUES(business), economics = VALUES(economics), further_maths = VALUES(further_maths), biology = VALUES(biology), computer = VALUES(computer), accounting = VALUES(accounting), gpa = VALUES(gpa)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Loop through the submitted form data
    foreach ($_POST['rollNumber'] as $rollNumber) {
        $elang = $_POST['elang'][$rollNumber];
        $general_paper = $_POST['general_paper'][$rollNumber];
        $maths = $_POST['maths'][$rollNumber];
        $physics = $_POST['physics'][$rollNumber];
        $chemistry = $_POST['chemistry'][$rollNumber];
        $business = $_POST['business'][$rollNumber];
        $economics = $_POST['economics'][$rollNumber];
        $further_maths = $_POST['further_maths'][$rollNumber];
        $computer = $_POST['computer'][$rollNumber];
        $accounting = $_POST['accounting'][$rollNumber];
        $biology = $_POST['biology'][$rollNumber];

        // Calculate GPA using the aLevelsGPA function
        $gpa = aLevelsGPA($elang, $general_paper, $maths, $physics, $chemistry, $business, $economics, $further_maths, $computer, $accounting, $biology);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sdddddddddddd", $rollNumber, $elang, $general_paper, $maths, $physics, $chemistry, $business, $economics, $further_maths, $biology, $computer, $accounting, $gpa);

        // Execute the statement
        mysqli_stmt_execute($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

entryFieldsGrade($standard, $system, $table_name, $conn);