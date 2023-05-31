<?php

// loggedin function and usertype function
function loggedin()
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return true;
    } else {
        return false;
    }
}

function usertype()
{
    if (isset($_SESSION['user_type']) && !empty($_SESSION['user_type'])) {
        return $_SESSION['user_type'];
    } else {
        return false;
    }
}


// check if superadmin

function is_super_admin()
{
    if (isset($_SESSION['user_type']) && !empty($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] == "super_admin") {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function username()
{
    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
        return $_SESSION['username'];
    } else {
        return false;
    }
}

// if not admin, display error page

function superadmin_only()
{
    if (!is_super_admin()) {
        header("Location: index.php");
        exit();
    }
}

// if not logged in, display error page
function loggedin_only()
{
    if (!loggedin()) {
        header("Location: index.php");
        exit();
    }
}

function success($message)
{
?>
    <div class="alert alert-success" role="alert">
        <?php echo $message; ?>
    </div>
<?php
}

function fail($message)
{
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
<?php
}


function isValidRollNumber($rollNumber)
{
    return preg_match('/^\d{4}[A-Z]$/', $rollNumber);
}

function deleteStudent($rollNumber, $conn)
{
    $sql = "SELECT school_system, high_school_system FROM students WHERE roll_no = '$rollNumber'";
    $result = mysqli_query($conn, $sql);
    // delete the students grade data
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $school_system = $row['school_system'];
        $high_school_system = $row['high_school_system'];
        $sql = "DELETE FROM nine_" . $school_system . " WHERE roll_no = '$rollNumber'";
        $sql2 = "DELETE FROM ten_" . $school_system . " WHERE roll_no = '$rollNumber'";
        $sql3 = "DELETE FROM eleven_" . $high_school_system . " WHERE roll_no = '$rollNumber'";
        $sql4 = "DELETE FROM twelve_" . $high_school_system . " WHERE roll_no = '$rollNumber'";
        $sql5 = "DELETE FROM students WHERE roll_no = '$rollNumber'";

        $result = mysqli_query($conn, $sql);
        $result2 = mysqli_query($conn, $sql2);
        $result3 = mysqli_query($conn, $sql3);
        $result4 = mysqli_query($conn, $sql4);
        $result5 = mysqli_query($conn, $sql5);

        if (!$result || !$result2 || !$result3 || !$result4 || !$result5) {
            fail("Failed to delete student!");
            return;
        }
    } else {
        fail("Student not found");
        return;
    }
}

function entryFieldsGrade($standard, $system, $tableName, $conn)
{

    // 0 is school 1 is highschool

    $success_count = 0;
    $fail_count = 0;
    // Connect to the database
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch the column information from the given table
    $sql = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tableName'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $columns = array();
        while ($row = mysqli_fetch_assoc($result)) {
            // Exclude non-subject columns like primary key, etc.
            if ($row['COLUMN_NAME'] != 'id' && $row['COLUMN_NAME'] != 'roll_no' && $row['COLUMN_NAME'] != 'gpa') {
                $columns[$row['COLUMN_NAME']] = $row['DATA_TYPE'];
            }
        }
    } else {
        fail("No subjects found");
        return;
    }

    // Fetch student roll numbers from the "students" table
    $sql = "SELECT roll_no FROM students";
    if ($standard == 0) {
        if ($system == 0) {
            $sql = "SELECT roll_no FROM students WHERE school_system = 'neb'";
        }
    } else if ($standard == 1) {
        if ($system == 0) {
            $sql = "SELECT roll_no FROM students WHERE high_school_system = 'neb'";
        } else if ($system == 1) {
            $sql = "SELECT roll_no FROM students WHERE high_school_system = 'alevels'";
        } else {
            fail("No system selected");
        }
    } else {
        fail("No standard selected");
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error fetching student roll numbers: " . mysqli_error($conn);
        return;
    }

    if (mysqli_num_rows($result) > 0) {
        $rollNumbers = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rollNumber = $row['roll_no'];
            $rollNumbers[] = $rollNumber;

            // Check if the student already has a record in the grade table
            $sql = "SELECT roll_no FROM $tableName WHERE roll_no = '$rollNumber'";
            $existingResult = mysqli_query($conn, $sql);
            if (!$existingResult) {
                echo "Error checking existing records: " . mysqli_error($conn);
                return;
            }
            if (mysqli_num_rows($existingResult) === 0) {
                // If the student does not have a record, insert a new row with default values
                $defaultValues = array_fill_keys(array_keys($columns), '');
                $defaultValues['roll_no'] = $rollNumber;
                $values = implode("', '", $defaultValues);
                $sql = "INSERT INTO $tableName (`" . implode('`, `', array_keys($defaultValues)) . "`) VALUES ('$values')";
                mysqli_query($conn, $sql);
            }
        }
    } else {
        fail("No students found in the database.");
        return;
    }

    // Fetch marks data from the specified table
    $sql = "SELECT roll_no, " . implode(', ', array_keys($columns)) . " FROM $tableName";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $marksData = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rollNumber = $row['roll_no'];
            unset($row['roll_no']); // Remove roll_no from the row data
            $marksData[$rollNumber] = $row;
        }
    } else {
        fail("No data found in the table.");
        return;
    }

    // Handle form submission and update database
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $rollNumbers = $_POST['rollNumber'];
        foreach ($rollNumbers as $rollNumber) {
            foreach ($columns as $column => $dataType) {
                $value = $_POST[$column][$rollNumber];
                if ($dataType === 'float' && $value === '') {
                    $value = 'NULL'; // Set empty float values to NULL
                }
                // Update the database with the new value
                $sql = "UPDATE $tableName SET $column = $value WHERE roll_no = '$rollNumber'";
                if (mysqli_query($conn, $sql)) {
                    $success_count += 1;
                } else {
                    $fail_count += 1;
                }
            }
        }
        // Redirect to the same page to display updated data
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }

    // Generate the form table
?>
    <div class="container mt-5">
        <div>
            <h1 align="center" class="mb-5"><?php echo $tableName; ?></h1>
            <form action="#" method="POST">
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Roll Number</th>
                                <?php foreach ($columns as $column => $dataType) { ?>
                                    <th><?php echo ucfirst($column); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rollNumbers as $rollNumber) { ?>
                                <tr>
                                    <td>
                                        <input type="hidden" name="rollNumber[]" value="<?php echo $rollNumber; ?>">
                                        <?php echo $rollNumber; ?>
                                    </td>
                                    <?php foreach ($columns as $column => $dataType) { ?>
                                        <td>
                                            <?php
                                            $inputType = ($dataType == 'float') ? 'number' : 'text';
                                            $value = isset($marksData[$rollNumber][$column]) ? $marksData[$rollNumber][$column] : '';
                                            ?>
                                            <input type="<?php echo $inputType; ?>" step="0.01" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?>" value="<?php echo $value; ?>">
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
<?php

    // Close the database connection
    mysqli_close($conn);
}


function getTotalStudents($conn)
{
    // Perform the database query to count the total number of students
    // and return the result
    $query = "SELECT COUNT(*) AS total_students FROM students";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_students'];
}

// Function to get the number of passed students
function getPassedStudents($conn)
{
    // Perform the database query to count the number of students with GPA higher than 0
    // and return the result
    $query = "SELECT COUNT(*) AS passed_students FROM twelve_neb WHERE gpa > 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['passed_students'];
}

// Function to get the number of failed students
function getFailedStudents($conn)
{
    // Perform the database query to count the number of students with GPA equal to 0
    // and return the result
    $query = "SELECT COUNT(*) AS failed_students FROM twelve_neb WHERE gpa = 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['failed_students'];
}

function generateStudentPDF($directory, $rollNo, $conn, $generateMode)
{
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
        $pdf->Output($directory . $rollNo . "_" . $firstName . '_studentprofile.pdf', $generateMode);
    }
}

function getRank($roll, $conn)
{
    $rank = 0;

    // Check the system of high school
    $query = "SELECT high_school_system FROM students WHERE roll_no = '$roll'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $high_school_system = $row['high_school_system'];
    }

    // Check if the student is from NEB or A Level (assuming 'neb' is the correct value for NEB)

    if ($high_school_system == "neb") {
        // Get the student's GPA
        $query = "SELECT gpa FROM twelve_neb WHERE roll_no = '$roll'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $gpa = $row['gpa'];

        // Calculate the rank
        $query = "SELECT DISTINCT gpa FROM twelve_neb ORDER BY gpa DESC";
        $result = mysqli_query($conn, $query);
        $rank = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['gpa'] > $gpa) {
                $rank++;
            }
        }
    }

    // Return the rank
    return $rank;
}
