<?php

$table_name = "ten_neb";
$standard = 0;
$system = 0;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to insert or update marks in the nine_neb table
    $sql = "INSERT INTO $table_name (roll_no, nepali, english, maths, social, hpe, omaths, computer, economics, geography, gpa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE nepali = VALUES(nepali), english = VALUES(english), maths = VALUES(maths), social = VALUES(social), hpe = VALUES(hpe), omaths = VALUES(omaths), computer = VALUES(computer), economics = VALUES(economics), geography = VALUES(geography), gpa = VALUES(gpa)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "sdddddddddd", $rollNumber, $nepali, $english, $maths, $social, $hpe, $omaths, $computer, $economics, $geography, $gpa);

    // Loop through the submitted form data
    foreach ($_POST['rollNumber'] as $rollNumber) {
        $nepali = $_POST['nepali'][$rollNumber];
        $english = $_POST['english'][$rollNumber];
        $maths = $_POST['maths'][$rollNumber];
        $social = $_POST['social'][$rollNumber];
        $hpe = $_POST['hpe'][$rollNumber];
        $omaths = $_POST['omaths'][$rollNumber];
        $computer = $_POST['computer'][$rollNumber];
        $economics = $_POST['economics'][$rollNumber];
        $geography = $_POST['geography'][$rollNumber];

        // Calculate the final grade and GPA
        $gpa = schoolNebGPA($nepali, $english, $maths, $social, $hpe, $omaths, $computer, $economics, $geography);

        // Execute the statement
        mysqli_stmt_execute($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

entryFieldsGrade($standard, $system, $table_name, $conn);
