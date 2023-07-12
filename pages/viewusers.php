<?php

loggedin_only();

if(isset($_GET['status'])){
    if($_GET['status'] == 'success'){
        echo "<div class='alert alert-success' role='alert'>Successfully deleted the account</div>";
    }
}

?>

<div class="grade-area">
    <div class="grade-container">
        <div style="font-size: 20px; font-weight: bold; margin-bottom: 20px;">Users</div>
        <div class="table-div">
            <table id="student-table" border=1>
                <thead>
                    <th>ID</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Action</th>
                </thead>
                <?php
                // Database connection (same as above)
                // ...


                $sql = "SELECT * FROM msauth";

                $result = $conn->query($sql);

                // Display student data in the table
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['user_type'] . "</td>";
                        echo "<td><button class = 'custom-button' onclick='deleteAccount(" . $row['id'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
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
    function deleteAccount(id) {
        if (confirm("Are you sure you want to delete this account?")) {
            window.location.href = "index.php?page=deleteaccount&id=" + id;
        }
    }
</script>