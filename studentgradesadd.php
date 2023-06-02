<?php
include("includes/header.php");
loggedin_only();
?>

<!-- grade specific forms and SQL -->
<?php

// if grade is selected and option is selected include the grade form
if (isset($_GET['grade']) && isset($_GET['option'])) {
    $grade = $_GET['grade'];
    $option = $_GET['option'];
    include("gradeforms/grade" . $grade . $option . ".php");
} else if (isset($_GET['grade']) && !isset($_GET['option'])) {
    $grade = $_GET['grade'];
    if ($grade == "sat") {
        include('gradeforms/sat.php');
    } else {
        include("gradeforms/grade" . $grade . ".php");
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