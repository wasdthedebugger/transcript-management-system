<?php
loggedin_only();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-top: 0;
    }

    form {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    select {
        padding: 10px;
    }

    input[type="text"] {
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

    input[type="submit"] {
        display: block;
        margin-top: 20px;
    }

    iframe {
        width: 100%;
        height: 100vh;
    }
</style>

<div class="container">
    <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Generate Transcript</div>
    <form action="#" method="POST">
        <label for="roll_no">Roll No</label>
        <input type="text" name="roll_no" id="roll_no" placeholder="Enter Roll No">

        <label for="batch">Batch</label>
        <select name="batch" id="batch">
            <option value="">Select Batch</option>
            <!-- Populate the dropdown with distinct batches from the students table -->
            <?php
            $batchSql = "SELECT DISTINCT batch FROM students";
            $batchResult = mysqli_query($conn, $batchSql);
            while ($row = mysqli_fetch_assoc($batchResult)) {
                $batchValue = $row['batch'];
                echo "<option value='$batchValue'>$batchValue</option>";
            }
            ?>
        </select>
        <input type="submit" class="custom-button" value="Generate">
    </form>
    <?php

    if (isset($_POST['roll_no']) && $_POST['roll_no'] != "") {
        // Individual student generation
        $roll_no = $_POST['roll_no'];
        $mode = "I";
    ?>
        <iframe src="pdf.php?roll_no=<?php echo $roll_no ?>&mode=<?php echo $mode ?>" frameborder="0"></iframe>
        <?php
    } elseif (isset($_POST['batch'])) {
        // Bulk generation by batch
        $batch = $_POST['batch'];
        $mode = "D"; // D for download, I for inline display

        // Fetch student data by batch
        $sql = "SELECT roll_no FROM students WHERE batch = '$batch'";
        $result = mysqli_query($conn, $sql);

        // Generate PDFs for each student in the batch
        while ($row = mysqli_fetch_assoc($result)) {
            $roll_no = $row['roll_no'];
        ?>
            <iframe src="pdf.php?roll_no=<?php echo $roll_no ?>&mode=<?php echo $mode ?>" frameborder="0"></iframe>
    <?php
        }
    } else {
    }
    ?>

</div>