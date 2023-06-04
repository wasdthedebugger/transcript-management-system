<?php
include('includes/header.php');
superadmin_only();

// Fetch roll numbers from the database
$query = "SELECT roll_no FROM students";
$result = mysqli_query($conn, $query);
$batches = array();

// Calculate available batches
while ($row = mysqli_fetch_assoc($result)) {
    $roll_no = $row['roll_no'];
    $batch = $roll_no[0] . "000" . $roll_no[-1]; // Extract the first digit and the last character
    if (!in_array($batch, $batches)) {
        $batches[] = $batch;
    }
}

// Check if a specific batch is selected
if (isset($_GET['batch'])) {
    $selected_batch = $_GET['batch'];
} else {
    $selected_batch = ""; // Empty by default
}
?>

<div class="container mt-5">
    <h1 class="mb-5" align="center">Manage Students</h1>
    <form class="mb-4" method="GET">
        <div class="form-group row">
            <label for="batch" class="col-sm-2 col-form-label">Select Batch:</label>
            <div class="col-sm-4">
                <select class="form-control" id="batch" name="batch">
                    <option value="" <?php echo ($selected_batch == "") ? "selected" : ""; ?>>All Batches</option>
                    <?php
                    // Populate batch options dynamically
                    foreach ($batches as $batch) {
                        $selected = ($selected_batch == $batch) ? "selected" : "";
                        echo "<option value=\"$batch\" $selected>$batch</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <?php
    // Modify the SQL query to include batch filtering if a specific batch is selected
    $query = "SELECT roll_no, first_name, middle_name, last_name FROM students";

    if ($selected_batch != "") {
        $start_roll = $selected_batch[0] . "000A"; // Set the starting roll number of the selected batch
        $end_roll = $selected_batch[0] . "999Z"; // Calculate the ending roll number of the selected batch
        $query .= " WHERE roll_no >= '$start_roll' AND roll_no <= '$end_roll'";
    }

    $result = mysqli_query($conn, $query);

    // Check if there are any records
    if (mysqli_num_rows($result) > 0) {
    ?>
        <div class="table-responsive">
            <table class="table table-bordered table-light">
                <thead class="thead-light">
                    <tr>
                        <th>Roll Number</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Output data for each row
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['roll_no']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['middle_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td>
                                <button class="btn btn-danger" onclick="deleteStudent('<?php echo $row['roll_no']; ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    } else {
        echo "<p class='text-center'>No records found.</p>";
    }

    // Close the connection
    mysqli_close($conn);
    ?>
</div>

<script>
// Confirm deletion of student
function deleteStudent(roll_no) {
    if (confirm("Are you sure you want to delete this student?")) {
        window.location.href = "delete.php?roll_no=" + roll_no;
    }
}
</script>

<?php include('includes/footer.php'); ?>
