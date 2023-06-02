<?php

// include
include("../includes/conn.php");

$tables = [
    "nine_neb",
    "ten_neb",
    "eleven_neb",
    "twelve_neb",
    "students",
    "sat",
    "eleven_alevels",
    "twelve_alevels",
    "users"
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

// insert into users a default admin user

$sql = "INSERT INTO users (id, username, password, email, user_type) VALUES (1, 'admin', 'admin123', 'admin@admin.com', 'super_admin')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Data inserted into users <br>";
} else {
    echo "Error: " . mysqli_error($conn);
}