<?php
include("includes/header.php");
loggedin_only();
?>

<!-- grade specific forms and SQL -->
<?php

// if grade is selected and system is selected include the grade form
if (isset($_GET['grade']) && isset($_GET['system'])) {
    $grade = $_GET['grade'];
    $system = $_GET['system'];
    include("gradeforms/" . $grade . $system . ".php");
} else if (isset($_GET['grade']) && !isset($_GET['system'])) {
    $grade = $_GET['grade'];
    if ($grade == "sat") {
        include('gradeforms/sat.php');
    } else {
        include("gradeforms/" . $grade . ".php");
    }
} else {
    header("Location: studentgrades.php");
}
?>

<?php include("includes/footer.php"); ?>

<style>
    input[type="number"] {
        width: 70px;
    }
</style>