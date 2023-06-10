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

function entryFieldsGrade($standard, $system, $tableName, $conn)
{
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
                                            $value = isset($marksData[$rollNumber][$column]) ? $marksData[$rollNumber][$column] : '';
                                            if ($standard == 2 && $system == 0) {
                                            ?>
                                                <input style="width: 100%;" type="number" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?> " value="<?php echo $value; ?>">
                                            <?php
                                            } else if (($standard == 0 && $system == 0) || ($standard == 1 && $system == 0)) {
                                            ?>
                                                <select style="width:70px;" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?>">
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
                                                <select style="width:70px;" class="form-control" name="<?php echo $column . '[' . $rollNumber . ']'; ?>">
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
        return '*';
    }
}

function getLetterGradeAlevels($numericalGrade)
{
    if ($numericalGrade >= 90) {
        return 'A*';
    } elseif ($numericalGrade >= 80) {
        return 'A';
    } elseif ($numericalGrade >= 70) {
        return 'B';
    } elseif ($numericalGrade >= 60) {
        return 'C';
    } elseif ($numericalGrade >= 50) {
        return 'D';
    } elseif ($numericalGrade >= 40) {
        return 'E';
    } elseif ($numericalGrade > 0) {
        return 'NG';
    } else {
        return '*';
    }
}
