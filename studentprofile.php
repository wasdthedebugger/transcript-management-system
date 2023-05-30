<?php require('includes/header.php'); ?>
<div id="notice"></div>
<div class="container mt-5">
    <h1 class="mb-4" align="center">Student Profile</h1>

    <?php
    require('includes/conn.php');

    // Fetch all roll numbers from the students table
    $rollNumberQuery = "SELECT roll_no FROM students";
    $rollNumberResult = mysqli_query($conn, $rollNumberQuery);
    $rollNumbers = array();

    while ($row = mysqli_fetch_assoc($rollNumberResult)) {
        $rollNumbers[] = $row['roll_no'];
    }
    ?>

    <form id="student_form">
        <div class="form-group">
            <label for="roll_no">Roll Number:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="roll_no" name="roll_no" placeholder="Type roll number">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <br><br>

    <div id="pdf_container" class="embed-responsive embed-responsive-16by9" style="display: none;">
        <iframe class="embed-responsive-item" id="pdf_viewer" src=""></iframe>
    </div>
</div>

<script>
    // Pass the rollNumbers array from PHP to JavaScript
    var rollNumbers = <?php echo json_encode($rollNumbers); ?>;

    // Update the src attribute of the PDF viewer iframe when the form is submitted
    document.getElementById('student_form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission
        var rollNo = document.getElementById('roll_no').value;
        var pdfViewer = document.getElementById('pdf_viewer');
        var pdfContainer = document.getElementById('pdf_container');

        // Only show the PDF viewer if a valid roll number is entered
        if (rollNo && rollNumbers.includes(rollNo)) {
            pdfContainer.style.display = 'block';
            pdfViewer.src = 'pdf.php?roll_no=' + encodeURIComponent(rollNo);
        } else {
            document.getElementById('notice').innerHTML = '<div class="alert alert-danger">Please enter a valid roll number.</div>';
            pdfContainer.style.display = 'none';
        }
    });
</script>
<?php include("includes/footer.php"); ?>
