<?php include('includes/header.php');
superadmin_only(); ?>

<div class="container mt-5">
    <h1 class="mb-5" align="center">Manage Students</h1>
    <?php
    $query = "SELECT roll_no, first_name, middle_name, last_name FROM students";
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
