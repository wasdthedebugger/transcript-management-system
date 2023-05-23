<?php
require('fpdf/fpdf.php');

// Sample data for the mark sheet
$studentName = 'John Doe';
$rollNumber = '101';
$subjectNames = ['Mathematics', 'Science', 'English'];
$marks = [90, 85, 92];
$totalMarks = array_sum($marks);
$percentage = ($totalMarks / (count($subjectNames) * 100)) * 100;

// Create a new PDF document
$pdf = new FPDF();

// Add a page to the PDF
$pdf->AddPage();

// Set the font and font size
$pdf->SetFont('Arial', 'B', 14);

// Title
$pdf->Cell(0, 10, 'Mark Sheet', 0, 1, 'C');

// Line break
$pdf->Ln(10);

// Student details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Student Name: ');
$pdf->Cell(0, 10, $studentName, 0, 1);

$pdf->Cell(50, 10, 'Roll Number: ');
$pdf->Cell(0, 10, $rollNumber, 0, 1);

$pdf->Ln(5);

// Mark details
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Subject', 1);
$pdf->Cell(40, 10, 'Marks', 1, 0, 'C');
$pdf->Cell(40, 10, 'Out of', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($subjectNames as $index => $subject) {
    $pdf->Cell(80, 10, $subject, 1);
    $pdf->Cell(40, 10, $marks[$index], 1, 0, 'C');
    $pdf->Cell(40, 10, '100', 1, 0, 'C');
    $pdf->Ln();
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Total', 1);
$pdf->Cell(40, 10, $totalMarks, 1, 0, 'C');
$pdf->Cell(40, 10, count($subjectNames) * 100, 1, 0, 'C');
$pdf->Ln();

$pdf->Cell(80, 10, 'Percentage', 1);
$pdf->Cell(80, 10, number_format($percentage, 2) . '%', 1, 0, 'C');

// Output the PDF
$pdf->Output();
?>
