<?php
include("includes/header.php");
superadmin_only();

if (isset($_GET['roll_no'])) {

    $rollNo = $_GET['roll_no'];
    deleteStudent($rollNo, $conn);
    header("Location: students.php");
} else {
    fail("No roll number specified");
}

include("includes/footer.php");