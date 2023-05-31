<?php
include("includes/header.php");
superadmin_only();

if (isset($_GET['roll_no'])) {
    header("Location: students.php");
    $rollNo = $_GET['roll_no'];
    deleteStudent($rollNo, $conn);
} else {
    fail("No roll number specified");
}

include("includes/footer.php");
