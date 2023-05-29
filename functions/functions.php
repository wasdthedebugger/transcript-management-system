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
        echo "No subjects found in the table.";
        return;
    }

    // Fetch student roll numbers and marks from the specified table
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
        echo '<div>No students found.</div>';
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
            <h2><?php echo $tableName; ?></h2>
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
                        <?php foreach ($marksData as $rollNumber => $marks) { ?>
                            <tr>
                                <td><input type="hidden" name="rollNumber[]" value="<?php echo $rollNumber; ?>"><?php echo $rollNumber; ?></td>
                                <?php foreach ($columns as $column => $dataType) { ?>
                                    <td>
                                        <?php
                                        $inputType = ($dataType == 'float') ? 'number' : 'text';
                                        $value = isset($marks[$column]) ? $marks[$column] : '';
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
