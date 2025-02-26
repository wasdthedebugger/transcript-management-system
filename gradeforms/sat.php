<?php

$table_name = "sat";
$standard = 2;
$system = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to insert or update marks in the nine_neb table
    $sql = "INSERT INTO $table_name (roll_no, score, maths, english) VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE score = VALUES(score), maths = VALUES(maths), english = VALUES(english)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "sddd", $rollNumber, $score, $maths, $english);

    // Loop through the submitted form data
    foreach ($_POST['rollNumber'] as $rollNumber) {
        $score = $_POST['score'][$rollNumber];
        $maths = $_POST['maths'][$rollNumber];
        $english = $_POST['english'][$rollNumber];
        // Execute the statement
        mysqli_stmt_execute($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Redirect to a success page or display a success message
    success('Marks inserted successfully!');
}
// generate form 
entryFieldsGrade($standard, $system, $table_name, $conn);