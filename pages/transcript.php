<?php

if (isset($_POST['roll_no'])) {
    // Single student generation
    $roll_no = $_POST['roll_no'];
    $mode = isset($_POST['download']) ? 'D' : 'I'; // D for download, I for inline display
    ?>
        <iframe src="pdf.php?roll_no=<?php echo $roll_no ?>&mode=<?php echo $mode ?>" frameborder="0"></iframe>
    <?php
} elseif (isset($_POST['batch'])) {
    // Bulk generation by batch
    $batch = $_POST['batch'];
    $mode = isset($_POST['download']) ? 'D' : 'I'; // D for download, I for inline display

    // Fetch student data by batch
    $sql = "SELECT roll_no FROM students WHERE batch = '$batch'";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $roll_no = $row['roll_no'];
        ?>
            <iframe src="pdf.php?roll_no=<?php echo $roll_no ?>&mode=<?php echo $mode ?>" frameborder="0"></iframe>
        <?php
    }
}
?>

<form action="#" method="POST">
    <input type="text" name="roll_no" placeholder="Enter Roll No">
    <select name="batch">
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
    <input type="checkbox" name="download" id="download">
    <label for="download">Download</label>
    <input type="submit" value="Generate">
</form>
