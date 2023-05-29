<?php include("includes/header.php"); ?>

<?php

loggedin_only();

?>

<!-- grade specific forms and SQL -->
<?php

// if grade is selected and option is selected include the grade form
if (isset($_GET['grade']) && isset($_GET['option'])) {
    $grade = $_GET['grade'];
    $option = $_GET['option'];
    include("gradeforms/grade" . $grade . $option . ".php");
}else if (isset($_GET['grade'])) {
    $grade = $_GET['grade'];
    include("gradeforms/grade" . $grade . ".php");
}else{
    header("Location: studentgrades.php");
}
?>

<?php include("includes/footer.php"); ?>