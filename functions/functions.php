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

function entryFieldsGrade($tableName, $conn) {
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
                mysqli_query($conn, $sql);
            }
        }
        // Redirect to the same page to display updated data
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }

    // Generate the form table
    ?>
    <div class="container mt-5">
        <div style="overflow-x: auto; width: 100%;">
            <h1 align="center" class="mb-5"><?php echo $tableName; ?></h1>
            <form action="#" method="POST">
                <table class="table">
                    <thead>
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <?php

    // Close the database connection
    mysqli_close($conn);
}


function getTotalStudents($conn) {
    // Perform the database query to count the total number of students
    // and return the result
    $query = "SELECT COUNT(*) AS total_students FROM students";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_students'];
}

// Function to get the number of passed students
function getPassedStudents($conn) {
    // Perform the database query to count the number of students with GPA higher than 0
    // and return the result
    $query = "SELECT COUNT(*) AS passed_students FROM twelve_neb WHERE gpa > 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['passed_students'];
}

// Function to get the number of failed students
function getFailedStudents($conn) {
    // Perform the database query to count the number of students with GPA equal to 0
    // and return the result
    $query = "SELECT COUNT(*) AS failed_students FROM twelve_neb WHERE gpa = 0";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['failed_students'];
}