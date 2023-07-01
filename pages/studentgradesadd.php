<?php
loggedin_only();
?>

<div class="grade-area">
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

</div>

<style>
    .grade-area {
        height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: left;
    }

    .grade-container {
        width: 100%;
        max-height: 70vh;
        overflow: auto;
    }

    /* fixed size table, if expand scroll */
    table {
        border-collapse: collapse;
    }

    th{
        text-align: left !important;
    }

    td {
        width: 100% !important;
        padding: 10px;
    }

    select {
        padding: 10px;
    }

    input[type="number"] {
        padding: 10px;
    }

    .custom-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #d6dfe8;
        border: none;
        cursor: pointer;
        color: red;
    }

    .custom-button:hover {
        background-color: #b3c0d1;
        color: black;
    }
</style>

<?php include("includes/footer.php"); ?>