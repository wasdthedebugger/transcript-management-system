<?php

require('fpdf/fpdf.php');
require('includes/conn.php');
require('functions/functions.php');

function generateStudentPDF($rollNo, $conn) {
    // Create a new PDF object
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Set font and cell padding
    $pdf->SetFont('Arial', '', 10);
    $cellWidth = 40;
    $cellHeight = 8;
    $cellPadding = 2;

    // Set colors
    $headerColor = array(100, 100, 100); // Dark gray
    $rowColors = array(array(230, 230, 230), array(255, 255, 255)); // Light gray and white

    // Retrieve the student information based on the roll number
    $studentQuery = "SELECT roll_no, first_name, middle_name, last_name FROM students WHERE roll_no = '$rollNo'";
    $studentResult = mysqli_query($conn, $studentQuery);

    // Check if the student exists
    if (mysqli_num_rows($studentResult) > 0) {
        $studentRow = mysqli_fetch_assoc($studentResult);
        $rollNo = $studentRow['roll_no'];
        $firstName = $studentRow['first_name'];
        $middleName = $studentRow['middle_name'];
        $lastName = $studentRow['last_name'];

        // Set student details
        $pdf->SetFont('Arial', 'B', 12);
        if ($middleName) {
            $pdf->Cell(0, $cellHeight, $firstName . '_' . $middleName . '_' . $lastName, 0, 1, 'C');
        } else {
            $pdf->Cell(0, $cellHeight, $firstName . '_' . $lastName, 0, 1, 'C');
        }
        $pdf->Ln();

        // Loop through each grade level
        $gradeLevels = ['nine_neb', 'ten_neb', 'eleven_neb', 'twelve_neb'];
        foreach ($gradeLevels as $index => $gradeLevel) {
            // Retrieve the grades for the current grade level and student
            $gradeQuery = "SELECT * FROM " . $gradeLevel . " WHERE roll_no = '$rollNo'";
            $gradeResult = mysqli_query($conn, $gradeQuery);

            // Check if there are grades for the current grade level
            if (mysqli_num_rows($gradeResult) > 0) {
                // Set the grade level as the section heading
                if ($index % 2 === 0) {
                    $pdf->SetX(10);
                } else {
                    $pdf->SetX(110);
                }
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell($cellWidth * 2, $cellHeight, 'Grade Level: ' . $gradeLevel, 0, 1, 'L');

                // Create the header row for subjects
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetX($pdf->GetX());
                $pdf->SetFillColor($headerColor[0], $headerColor[1], $headerColor[2]);
                $pdf->Cell($cellWidth, $cellHeight, 'Subject', 1, 0, 'C', true);
                $pdf->Cell($cellWidth, $cellHeight, 'Grade', 1, 1, 'C', true);

                // Loop through each grade record
                $rowColorIndex = 0;
                while ($gradeRow = mysqli_fetch_assoc($gradeResult)) {
                    // Loop through the columns (subjects and grades)
                    foreach ($gradeRow as $column => $value) {
                        if ($column === 'roll_no') {
                            continue; // Skip the roll_no column
                        }
                        if ($column === 'gpa' && $value === null) {
                            $value = 'N/A'; // Display "N/A" if GPA is null
                        }
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->SetX($pdf->GetX());
                        $pdf->SetFillColor($rowColors[$rowColorIndex % 2][0], $rowColors[$rowColorIndex % 2][1], $rowColors[$rowColorIndex % 2][2]);
                        $pdf->Cell($cellWidth, $cellHeight, $column, 1, 0, 'C', true);
                        $pdf->Cell($cellWidth, $cellHeight, $value, 1, 1, 'C', true);
                    }
                    $rowColorIndex++;
                }
                $pdf->Ln();
            }
        }

        // Output the PDF with the roll number and "_studentprofile" suffix
        $pdf->Output($rollNo ."_". $firstName . '_studentprofile.pdf', 'I');
    } 
}

// Usage example:
$rollNo = $_GET['roll_no']; // Assuming you pass the roll number as a parameter
generateStudentPDF($rollNo, $conn);
