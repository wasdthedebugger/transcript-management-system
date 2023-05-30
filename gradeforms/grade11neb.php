<?php

$table_name = "eleven_neb";

$subjects = array(
    'english' => 3,
    'english_pr' => 1,
    'nepali' => 2.25,
    'nepali_pr' => 0.75,
    'maths' => 3.75,
    'maths_pr' => 1.25,
    'physics' => 3.75,
    'physics_pr' => 1.25,
    'chemistry' => 3.75,
    'chemistry_pr' => 1.25,
    'computer' => 2.5,
    'computer_pr' => 2.5,
    'biology' => 3.25,
    'biology_pr' => 1.75
);

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
        // Initialize the variables
        $english = null;
        $english_pr = null;
        $nepali = null;
        $nepali_pr = null;
        $maths = null;
        $maths_pr = null;
        $physics = null;
        $physics_pr = null;
        $chemistry = null;
        $chemistry_pr = null;
        $computer = null;
        $computer_pr = null;
        $biology = null;
        $biology_pr = null;
        $gpa = null;

        $grades = array();
        $validGrades = array();
        $creditHours = array();

        foreach ($subjects as $subject => $creditHour) {
            if (isset($_POST[$subject][$rollNumber])) {
                $grade = $_POST[$subject][$rollNumber];
                if (is_numeric($grade)) {
                    if ($grade == 0) {
                        $gpa = 0; // Set GPA as non-grade (0) if any subject has a grade of 0
                        break;
                    }
                    $grades[$subject] = $grade;
                    $validGrades[] = $grade * $creditHour;
                    $creditHours[] = $creditHour;
                }
            }
        }

        // If GPA is not already set as non-grade (0), calculate it normally
        if (!isset($gpa)) {
            $gpa = null;
            if (!empty($validGrades)) {
                $totalCreditHours = array_sum($creditHours);
                $gpa = array_sum($validGrades) / $totalCreditHours;
            }
        }

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sddddddddddddddd", $rollNumber, $english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr, $gpa);

        // Execute the statement
        mysqli_stmt_execute($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Redirect to a success page or display a success message
    success('Marks inserted successfully!');
}

entryFieldsGrade($table_name, $conn);
