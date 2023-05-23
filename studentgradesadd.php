<?php include("includes/header.php"); ?>

<?php

loggedin_only();

// get the grade from the URL
if (isset($_GET['grade'])) {
    $grade = $_GET['grade'];
} else {
    header("Location: studentgrades.php");
}

?>

<!-- grade specific forms and SQL -->
<?php
$sql = "SELECT roll_no from students";
$result = mysqli_query($conn, $sql);
$roll_nos = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

include("gradeforms/grade".$grade.".php");

?>



<?php include("includes/footer.php"); ?>