<?php
// Include the FPDF library
require('fpdf/fpdf.php');
require('includes/conn.php');
require('functions/functions.php');

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all roll numbers from the students table
$rollNumberQuery = "SELECT roll_no FROM students";
$rollNumberResult = mysqli_query($conn, $rollNumberQuery);

if (mysqli_num_rows($rollNumberResult) > 0) {
    // Create a directory to store the generated PDFs
    $directory = "student_profiles/";
    if (!is_dir($directory)) {
        mkdir($directory);
    }

    // Loop through each row and generate the student profile PDFs
    while ($row = mysqli_fetch_assoc($rollNumberResult)) {
        $directory = "student_profiles/";
        $rollNo = $row['roll_no'];
        generateStudentPDF($directory, $rollNo, $conn, 'F');
    }
    header("Location: studentprofile.php?bulk=success");
} else {
    header("Location: studentprofile.php?bulk=error");
}

// Close the database connection
mysqli_close($conn);

