<?php

loggedin_only();

if (isset($_GET['addstudents'])) {
    echo "<div class='sidemenu'>";
    include("addstudents.php");
    echo "</div>";
}

if (isset($_GET['addcsv'])) {
    echo "<div class='sidemenu'>";
    include("csventry.php");
    echo "</div>";
}

// if add is true in the URL, show the add student form


?>

<div class="grade-area">
    <div class="grade-container">
        <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Students</div>
        <label for="batch-filter">Filter by Batch</label>
        <select id="batch-filter" onchange="filterByBatch(this.value)" style="margin-bottom: 20px;">
            <option value="">All</option>
            <?php


            // Fetch distinct batches from the students table
            $sql = "SELECT DISTINCT batch FROM students";
            $result = $conn->query($sql);

            // Populate the dropdown with batch options
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // if the batch is selected, mark it as selected
                    $selected = isset($_GET['batch']) && $_GET['batch'] == $row['batch'] ? 'selected' : '';
                    echo "<option value='" . $row['batch'] . "' $selected>" . $row['batch'] . "</option>";
                }
            }

            ?>
        </select>

        <div class="add"><a href=# onclick="toggleGetParameter('addstudents', 'true')">Add Students</a> or
            <a href=# onclick="toggleGetParameter('addcsv', 'true')">Upload CSV</a>
        </div>
        <div class="table-div">
            <table id="student-table" border=1>
                <thead>
                    <th>Roll No</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Batch</th>
                    <th>Action</th>
                </thead>
                <?php
                // Database connection (same as above)
                // ...

                // Fetch student data based on the selected batch (if any)
                $selectedBatch = isset($_GET['batch']) ? $_GET['batch'] : '';
                $sql = "SELECT * FROM students";
                if (!empty($selectedBatch) && $selectedBatch !== 'all') {
                    $sql .= " WHERE batch = '$selectedBatch'";
                }
                $result = $conn->query($sql);

                // Display student data in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['roll_no'] . "</td>";
                        echo "<td>" . $row['first_name'] . "</td>";
                        echo "<td>" . $row['middle_name'] . "</td>";
                        echo "<td>" . $row['last_name'] . "</td>";
                        echo "<td>" . $row['batch'] . "</td>";
                        echo "<td><button class = 'custom-button' onclick='deleteAccount(" . $row['roll_no'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No students found.</td></tr>";
                }

                ?>
            </table>
        </div>
    </div>
</div>
<style>
    .grade-area {
        height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: left;
    }

    .grade-container {
        padding: 20px;
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    /* fixed size table, if expand scroll */
    table {
        width: 80%;
        overflow: auto;
        border-collapse: collapse;
    }

    thead {
        background-color: #d6dfe8;
    }

    th {
        text-align: left !important;
        padding: 10px;
        min-width: 100px;
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

    .sidemenu {
        width: 25vw;
        height: 90vh;
        overflow-y: scroll;
        overflow-x: hidden;
        background-color: lightgray;
        right: 0;
        position: absolute;
        z-index: 9999;
    }

    .table-div {
        margin-top: 20px;
        max-height: 65vh;
        overflow: auto;
    }
</style>

<script>
    function filterByBatch(batch) {
        if (batch) {
            window.location.href = "?page=students&batch=" + batch;
        } else {
            window.location.href = "?page=students&batch=all";
        }
    }

    function deleteAccount(studentId) {
        // Implement your delete logic here
        console.log("Deleting student with ID: " + studentId);
    }

    function toggleGetParameter(paramName, paramValue) {
        var url = new URL(window.location.href);

        if (url.searchParams.has(paramName)) {
            url.searchParams.delete(paramName);
        } else {
            url.searchParams.append(paramName, paramValue);
        }

        // if csv is true, remove addstudents and vice versa
        if (paramName === 'addcsv') {
            url.searchParams.delete('addstudents');
        }
        
        if (paramName === 'addstudents') {
            url.searchParams.delete('addcsv');
        }

        window.location.href = url.href;
    }
</script>
</body>

</html>