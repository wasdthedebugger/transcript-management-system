<?php

// include
include("../includes/conn.php");

$tables = [
    "nine_neb",
    "ten_neb",
    "eleven_neb",
    "twelve_neb",
    "students"
];

// delete all data from all tables

foreach ($tables as $table) {
    $sql = "DELETE FROM $table WHERE 1";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "Data deleted from $table <br>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}