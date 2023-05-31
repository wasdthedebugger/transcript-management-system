<?php

require('fpdf/fpdf.php');
require('includes/conn.php');
require('functions/functions.php');

// Usage example:
$rollNo = $_GET['roll_no']; // Assuming you pass the roll number as a parameter
// false means it wont be downloaded, instead it will be shown in browser
$directory = "";
generateStudentPDF($directory, $rollNo, $conn, 'I');
