<!-- bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<?php

// Assuming you have established a successful database connection
// Assuming you have established a successful database connection
include("../includes/conn.php");

// Fetch the student data from the students table
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Create an empty array to store the student data
    $studentsData = array();

    // Fetch the GPA from each table based on the roll_no
    while ($row = mysqli_fetch_assoc($result)) {
        $rollNumber = $row['roll_no'];
        
        // Calculate the average GPA of grade 11 and 12 combined
        $gradeElevenGPA = getGPAFromTable('eleven_neb', $rollNumber, $conn);
        $gradeTwelveGPA = getGPAFromTable('twelve_neb', $rollNumber, $conn);
        $combinedGPA = ($gradeElevenGPA + $gradeTwelveGPA) / 2;

        $studentData = array(
            'roll_no' => $rollNumber,
            'nine_neb' => getGPAFromTable('nine_neb', $rollNumber, $conn),
            'ten_neb' => getGPAFromTable('ten_neb', $rollNumber, $conn),
            'eleven_neb' => $gradeElevenGPA,
            'twelve_neb' => $gradeTwelveGPA,
            'eleven_twelve_combined' => $combinedGPA
        );
        $studentsData[] = $studentData;
    }

    // Display the student data in a frontend table with Bootstrap styles
    echo '<table class="table table-striped">';
    echo '<thead class="thead-dark"><tr><th>Roll No</th><th>GPA (Nine NEB)</th><th>GPA (Ten NEB)</th><th>GPA (Eleven NEB)</th><th>GPA (Twelve NEB)</th><th>GPA (11-12 Combined)</th></tr></thead>';
    echo '<tbody>';
    foreach ($studentsData as $studentData) {
        echo '<tr>';
        echo '<td>' . $studentData['roll_no'] . '</td>';
        echo '<td>' . $studentData['nine_neb'] . '</td>';
        echo '<td>' . $studentData['ten_neb'] . '</td>';
        echo '<td>' . $studentData['eleven_neb'] . '</td>';
        echo '<td>' . $studentData['twelve_neb'] . '</td>';
        echo '<td>' . $studentData['eleven_twelve_combined'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    // Handle any errors in the query
    echo "Error: " . mysqli_error($conn);
}

// Function to fetch the GPA from a specific table based on the roll_no
function getGPAFromTable($table, $rollNumber, $conn) {
    $sql = "SELECT gpa FROM $table WHERE roll_no = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $rollNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $gpa);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $gpa;
}
