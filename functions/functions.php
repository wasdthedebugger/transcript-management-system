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
        fail("You are not authorized to view this page");
        exit();
    }
}

// if not logged in, display error page
function loggedin_only()
{
    if (!loggedin()) {
        fail("Please login to continue");
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

function entryFieldsGrade($standard, $system, $tableName, $conn)
{
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
            if ($row['COLUMN_NAME'] != 'id' && $row['COLUMN_NAME'] != 'roll_no' && $row['COLUMN_NAME'] != 'gpa' && $row['COLUMN_NAME'] != 'weight') {
                $columns[$row['COLUMN_NAME']] = $row['DATA_TYPE'];
            }
        }
    } else {
        echo "No subjects found";
        return;
    }

    // Fetch student roll numbers from the "students" table
    $sql = "";
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
            echo "No system selected";
            return;
        }
    } else if ($standard == 2) {
        if ($system == 0) {
            $sql = "SELECT roll_no FROM students WHERE standard_test = 'sat'";
        }
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        fail("Error fetching student roll numbers: " . mysqli_error($conn));
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
                fail("Error checking existing records: " . mysqli_error($conn));
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
        fail("No marks data found in the database.");
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
                mysqli_query($conn, $sql);
            }
        }
        // Redirect to the same page to display updated data
        header("Location: ?page=curriculum&status=success");
        exit();
    }

    // Generate the form table
?>
    <div style="padding: 20px; overflow-x: auto;">
        <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;"><?php echo $tableName; ?></div>
        <form action="#" method="POST">
            <div class="grade-container">
                <table border=1 class="grade-table">
                    <thead style="background-color: #d6dfe8;">
                        <tr>
                            <th style="padding: 10px;">Roll Number</th>
                            <?php foreach ($columns as $column => $dataType) { ?>
                                <th style="padding: 10px;"><?php echo ucfirst($column); ?></th>
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
                                    <td style="padding: 10px;">
                                        <?php
                                        $value = isset($marksData[$rollNumber][$column]) ? $marksData[$rollNumber][$column] : '';
                                        if ($standard == 2 && $system == 0) {
                                        ?>
                                            <input style="width: 70px;" type="number" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?> " value="<?php echo $value; ?>">
                                        <?php
                                        } else if (($standard == 0 && $system == 0) || ($standard == 1 && $system == 0)) {
                                        ?>
                                            <select style="width: 70px;" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?>">
                                                <option value="4.0" <?php if ($value === '4.0') echo 'selected'; ?>>A+</option>
                                                <option value="3.6" <?php if ($value === '3.6') echo 'selected'; ?>>A</option>
                                                <option value="3.2" <?php if ($value === '3.2') echo 'selected'; ?>>B+</option>
                                                <option value="2.8" <?php if ($value === '2.8') echo 'selected'; ?>>B</option>
                                                <option value="2.4" <?php if ($value === '2.4') echo 'selected'; ?>>C+</option>
                                                <option value="2.0" <?php if ($value === '2.0') echo 'selected'; ?>>C</option>
                                                <option value="1.6" <?php if ($value === '1.6') echo 'selected'; ?>>D</option>
                                                <option value="0" <?php if ($value === '0') echo 'selected'; ?>>NG</option>
                                                <option value="" <?php if ($value === '') echo 'selected'; ?>>No</option>
                                            </select>
                                        <?php
                                        } else {
                                        ?>
                                            <select style="width: 70px;" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?>">
                                                <option value="12" <?php if ($value === '12') echo 'selected'; ?>>A*</option>
                                                <option value="10" <?php if ($value === '10') echo 'selected'; ?>>A</option>
                                                <option value="8" <?php if ($value === '8') echo 'selected'; ?>>B</option>
                                                <option value="6" <?php if ($value === '6') echo 'selected'; ?>>C</option>
                                                <option value="4" <?php if ($value === '4') echo 'selected'; ?>>D</option>
                                                <option value="2" <?php if ($value === '2') echo 'selected'; ?>>E</option>
                                                <option value="0" <?php if ($value === '0') echo 'selected'; ?>>U</option>
                                                <option value="6" <?php if ($value === '6') echo 'selected'; ?>>a</option>
                                                <option value="5" <?php if ($value === '5') echo 'selected'; ?>>b</option>
                                                <option value="4" <?php if ($value === '4') echo 'selected'; ?>>c</option>
                                                <option value="3" <?php if ($value === '3') echo 'selected'; ?>>d</option>
                                                <option value="2" <?php if ($value === '2') echo 'selected'; ?>>e</option>
                                                <option value="1" <?php if ($value === '1') echo 'selected'; ?>>u</option>
                                                <option value="" <?php if ($value === '') echo 'selected'; ?>>No</option>
                                            </select>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div style="text-align: left; padding-top: 20px;">
                <button type="submit" class="custom-button">Update</button>
            </div>
        </form>
    </div>
<?php
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
    $total = $row['passed_students'];
    $query = "SELECT COUNT(*) AS passed_students FROM aggregate_alevels WHERE gpa > 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total += $row['passed_students'];
    return $total;
}

// Function to get the number of failed students
function getFailedStudents($conn)
{
    // Perform the database query to count the number of students with GPA equal to 0
    // and return the result
    $query = "SELECT COUNT(*) AS failed_students FROM twelve_neb WHERE gpa = 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total = $row['failed_students'];
    $query = "SELECT COUNT(*) AS failed_students FROM aggregate_alevels WHERE gpa = 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total += $row['failed_students'];
    return $total;
}

function getRank($roll, $batch, $conn)
{
    $rank = 0;

    // Check the system of high school
    $query = "SELECT high_school_system FROM students WHERE roll_no = '$roll' AND batch = '$batch'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $high_school_system = $row['high_school_system'];
    }

    // Check if the student is from NEB or A Level

    if ($high_school_system == "neb") {
        $table = "twelve_neb";
    } else {
        $table = "aggregate_alevels";
    }
    // Get the student's GPA
    $query = "SELECT gpa FROM $table WHERE roll_no = '$roll'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $gpa = $row['gpa'];

    // Calculate the rank
    $query = "SELECT DISTINCT gpa FROM $table ORDER BY gpa DESC";
    $result = mysqli_query($conn, $query);
    $rank = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['gpa'] > $gpa) {
            $rank++;
        }
    }

    // Return the rank
    return $rank;
}

function getGraduationDate($rollNo, $conn)
{
    // Retrieve the joining date from the database
    $joiningDateQuery = "SELECT joining_date FROM students WHERE roll_no = '$rollNo'";
    $joiningDateResult = mysqli_query($conn, $joiningDateQuery);

    if (mysqli_num_rows($joiningDateResult) > 0) {
        $joiningDate = mysqli_fetch_assoc($joiningDateResult)['joining_date'];

        // Add 2 years to the joining date
        $graduationYear = date('Y', strtotime($joiningDate . '+2 years'));

        return $graduationYear;
    }

    return null; // Return null if the joining date is not found
}


function getLetterGradeNEB($numericalGrade)
{
    if ($numericalGrade >= 4.0) {
        return 'A+';
    } elseif ($numericalGrade >= 3.6) {
        return 'A';
    } elseif ($numericalGrade >= 3.2) {
        return 'B+';
    } elseif ($numericalGrade >= 2.8) {
        return 'B';
    } elseif ($numericalGrade >= 2.4) {
        return 'C+';
    } elseif ($numericalGrade >= 2.0) {
        return 'C';
    } elseif ($numericalGrade >= 1.6) {
        return 'D';
    } elseif ($numericalGrade > 0) {
        return 'NG';
    } else {
        return '';
    }
}

function getNumericGradeNEB($letterGrade)
{
    switch ($letterGrade) {
        case 'A+':
            return 4.0;
        case 'A':
            return 3.6;
        case 'B+':
            return 3.2;
        case 'B':
            return 2.8;
        case 'C+':
            return 2.4;
        case 'C':
            return 2.0;
        case 'D':
            return 1.6;
        case 'NG':
            return 0.0;
        default:
            return '';
    }
}


function schoolNebGPA($nepali, $english, $maths, $social, $hpe, $omaths, $computer, $economics, $geography) {
    $subjects = array($nepali, $english, $maths, $social, $hpe, $omaths, $computer, $economics, $geography);
    $grades = array();
    $count = 0;

    foreach ($subjects as $subject) {
        if ($subject !== "") {
            $grades[] = $subject;
        }
    }

    if (!empty($grades)) {
        $count = count($grades);
    }

    // Calculate the GPA
    if ($count > 0) {
        if (in_array(0, $grades)) {
            return 0; // Set GPA to 0 if any subject grade is 0
        } else {
            return array_sum($grades) / $count;
        }
    } else {
        return 0; // Set GPA to 0 if no subjects are passed
    }
}

function highSchoolNebGPA($english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr) {
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

    $grades = array(
        'english' => $english,
        'english_pr' => $english_pr,
        'nepali' => $nepali,
        'nepali_pr' => $nepali_pr,
        'maths' => $maths,
        'maths_pr' => $maths_pr,
        'physics' => $physics,
        'physics_pr' => $physics_pr,
        'chemistry' => $chemistry,
        'chemistry_pr' => $chemistry_pr,
        'computer' => $computer,
        'computer_pr' => $computer_pr,
        'biology' => $biology,
        'biology_pr' => $biology_pr
    );

    $validGrades = array();
    $totalCreditHours = 0;

    foreach ($subjects as $subject => $creditHour) {
        if (isset($grades[$subject])) {
            $grade = $grades[$subject];
            if (is_numeric($grade)) {
                if ($grade == 0) {
                    return 0; // Return non-grade (0) if any subject has a grade of 0
                }
                $validGrades[] = $grade * $creditHour;
                $totalCreditHours += $creditHour;
            }
        }
    }

    if (empty($validGrades)) {
        return 0; // Return null if no valid grades found
    }

    $gpa = array_sum($validGrades) / $totalCreditHours;
    return $gpa;
}

function aLevelsGPA($elang, $general_paper, $maths, $physics, $chemistry, $business, $economics, $further_maths, $computer, $accounting, $biology) {
    // Create an array of subjects
    $subjects = array($elang, $general_paper, $maths, $physics, $chemistry, $business, $economics, $further_maths, $computer, $accounting, $biology);

    // Initialize variables
    $count = 0;
    $sum = 0;

    // Loop through subjects and calculate sum and count of non-null values
    foreach ($subjects as $subject) {
        if ($subject !== "") {
            $sum += $subject;
            $count++;
        }
    }

    // Calculate the GPA
    if ($count > 0) {
        $gpa = $sum / $count;
    } else {
        $gpa = 0;
    }

    return $gpa;
}

function getNumericGradeAlevels($letterGrade)
{
    switch ($letterGrade) {
        case 'A*':
            return 12;
        case 'A':
            return 10;
        case 'B':
            return 8;
        case 'C':
            return 6;
        case 'D':
            return 4;
        case 'E':
            return 2;
        case 'U':
            return 0;
        case 'a':
            return 6;
        case 'b':
            return 5;
        case 'c':
            return 4;
        case 'd':
            return 3;
        case 'e':
            return 2;
        case 'u':
            return 1;
        default:
            return ''; // or any other default value you prefer
    }
}

function getLetterGradeAlevels($numericGrade)
{
    switch ($numericGrade) {
        case 12:
            return 'A*';
        case 10:
            return 'A';
        case 8:
            return 'B';
        case 6:
            return 'C';
        case 4:
            return 'D';
        case 2:
            return 'E';
        case 0:
            return 'U';
        case 6:
            return 'a';
        case 5:
            return 'b';
        case 4:
            return 'c';
        case 3:
            return 'd';
        case 2:
            return 'e';
        case 1:
            return 'u';
        default:
            return ''; // or any other default value you prefer
    }
}
