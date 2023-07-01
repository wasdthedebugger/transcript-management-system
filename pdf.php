<?php

require('functions/functions.php');
require('vendor/autoload.php');
require('includes/conn.php');

$roll_no = $_GET['roll_no'];
$mode = $_GET['mode'];

// Fetch personal details from students table
$sql = "SELECT * FROM students WHERE roll_no = '$roll_no'";
$result = mysqli_query($conn, $sql);
$studentData = mysqli_fetch_assoc($result);

// Create an object to store the data
$data = (object) $studentData;

// Fetch additional data based on high school system
$highSchoolSystem = strtoupper($studentData['high_school_system']);

if ($highSchoolSystem == 'NEB') {
    // Fetch data from eleven_neb and twelve_neb tables
    $elevenNebQuery = "SELECT * FROM eleven_neb WHERE roll_no = '$roll_no'";
    $elevenNebResult = mysqli_query($conn, $elevenNebQuery);
    $elevenNebData = mysqli_fetch_assoc($elevenNebResult);
    unset($elevenNebData['roll_no']);
    $elevenNebGPA = $elevenNebData['gpa'];

    $twelveNebQuery = "SELECT * FROM twelve_neb WHERE roll_no = '$roll_no'";
    $twelveNebResult = mysqli_query($conn, $twelveNebQuery);
    $twelveNebData = mysqli_fetch_assoc($twelveNebResult);
    unset($twelveNebData['roll_no']);
    $twelveNebGPA = $twelveNebData['gpa'];

    // Convert NEB grades to letter grades
    $elevenNebData = array_map('getLetterGradeNEB', $elevenNebData);
    $elevenNebData['gpa'] = $elevenNebGPA;
    $twelveNebData = array_map('getLetterGradeNEB', $twelveNebData);
    $twelveNebData['gpa'] = $twelveNebGPA;

    // Assign NEB data to the object
    $data->eleven_neb = (object) $elevenNebData;
    $data->twelve_neb = (object) $twelveNebData;
} elseif ($highSchoolSystem == 'ALEVELS') {
    // Fetch data from aggregate_alevels table
    $alevelsQuery = "SELECT * FROM aggregate_alevels WHERE roll_no = '$roll_no'";
    $alevelsResult = mysqli_query($conn, $alevelsQuery);
    $alevelsData = mysqli_fetch_assoc($alevelsResult);
    unset($alevelsData['roll_no']);
    $alevelsGPA = $alevelsData['gpa'];

    // Convert A-Levels grades to numeric grades
    $alevelsData = array_map('getLetterGradeAlevels', $alevelsData);
    $alevelsData['gpa'] = $alevelsGPA;

    // Assign A-Levels data to the object
    $data->aggregate_alevels = (object) $alevelsData;
}

// Fetch standard_test data
$standardTest = $studentData['standard_test'];
if ($standardTest === 'SAT') {
    // Fetch data from SAT table
    $satQuery = "SELECT * FROM sat WHERE roll_no = '$roll_no'";
    $satResult = mysqli_query($conn, $satQuery);
    $satData = mysqli_fetch_assoc($satResult);

    // Assign SAT data to the object
    $data->sat = (object) $satData;
}

// Fetch data from nine_neb and ten_neb tables
$nineNebQuery = "SELECT * FROM nine_neb WHERE roll_no = '$roll_no'";
$nineNebResult = mysqli_query($conn, $nineNebQuery);
$nineNebData = mysqli_fetch_assoc($nineNebResult);
unset($nineNebData['roll_no']);
$nineNebGPA = $nineNebData['gpa'];


$tenNebQuery = "SELECT * FROM ten_neb WHERE roll_no = '$roll_no'";
$tenNebResult = mysqli_query($conn, $tenNebQuery);
$tenNebData = mysqli_fetch_assoc($tenNebResult);
unset($tenNebData['roll_no']);
$tenNebGPA = $tenNebData['gpa'];

// Convert NEB grades to letter grades
$nineNebData = array_map('getLetterGradeNEB', $nineNebData);
$nineNebData['gpa'] = $nineNebGPA;
$tenNebData = array_map('getLetterGradeNEB', $tenNebData);
$tenNebData['gpa'] = $tenNebGPA;

// Assign NEB data to the object
$data->nine_neb = (object) $nineNebData;
$data->ten_neb = (object) $tenNebData;

$data->rank = getRank($data->roll_no, $data->batch, $conn);
$data->high_school_system = $highSchoolSystem;

// Close the database connection
$file_name = $data->roll_no . "_" . $data->first_name . "_" . $data->middle_name . "_" . $data->last_name . '.pdf';

use Mpdf\Mpdf;

$pdf = new Mpdf();
$pdf->SetMargins(0, 0, 7, 0);
$pdf->WriteHTML(generateHTML($data));

$pdf->Output($file_name, $mode);


function generateHTML($data)
{
    $html = <<<EOT
    <head>
    
    <style>
        /* google fonts */

        @import url('https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap');

        

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 0.55em;
        }

        .heading {
            text-align: center;
        }

        .section-heading {
            font-weight: bold;
            font-size: 20px;
            background-color: gray;
            color: white;
            padding: 5px;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .personal-sat {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .personal {
            width: 50%;
            border: 1px solid black;
            padding: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sat {
            width: 50%;
            border: 1px solid black;
            padding: 5px;
        }

        .personal table {
            width: 100%;
        }

        .personal table td {
            padding: 2px;
        }

        .bold-tr {
            font-size: 1em;
            font-weight: bolder;
        }

        .sat table {
            width: 100%;
        }

        .sat table tr td {
            padding: 2px;
        }

        .info-nine-ten .info table {
            width: 100%;
            margin: auto;
            text-align: center;
        }

        .info-nine-ten .desc {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: justify;
        }

        .nine-ten {
            gap: 20px;
        }

        .nine-ten div {
            padding: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .nine-ten div table {
            width: 100%;
            border-collapse: collapse;
        }

        .nine-ten div table tr td {
            font-size: 1em;
            padding: 0 20px 0 20px;
        }

        .personal-detail-wrapping-table {
            width: 100%;
        }

        .personal-detail-wrapping-table td {
            padding: 2px;
        }

        .nine-ten-wrapping-table {
            width: 100%;
            margin-left: 4em;
        }

        .nine-ten-wrapping-table td {
            padding-left: 10px;
            padding-right: 10px;
        }

        .sign-area td {
            padding-left: 20px;
            padding-right: 20px;
        }
        /* CSS styles for the page */

    </style>
</head>
<br><br><br><br>
<h1 class="heading">OFFICIAL TRANSCRIPT</h1>

<div class="section-heading">
    Student Information
</div>

<div class="personal-sat">
    <table class="personal-detail-wrapping-table">
        <tr>
            <td>
                <div class="personal">
                    <table>
                        <tr class="bold-tr">
                            <td>Name</td>
                            <td>DOB</td>
                            <td>SEX</td>
                        </tr>
                        <tr>
                            <td>{$data->first_name}</td>
                            <td>{$data->dob}</td>
                            <td>{$data->sex}</td>
                        </tr>
                        <tr class="bold-tr">
                            <td>Municipality</td>
                            <td>District</td>
                            <td>Province</td>
                        </tr>
                        <tr>
                            <td>{$data->municipality}</td>
                            <td>{$data->district}</td>
                            <td>{$data->province}</td>
                        </tr>
                        <tr class="bold-tr">
                            <td>Roll Number: {$data->roll_no}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td>
                <div class="sat">
                    <table>
                        <tr>
                            <td><b>Date of Graduation (or expected):</b> June 2022</td>
                        </tr>
                        <tr>
                            <td><b>Graduating Class Rank (projected if not graduated): {$data->rank}</b></td>
                        </tr>
                        <tr>
                            <td><b>Sat (If avaiable): {$data->sat->score} </b></td>
                        </tr>
                        <tr>
                            <td><b>Highest Composite: 1400</b></td>
                        </tr>
                        <tr>
                            <td><b>Highest Sub Section</b></td>
                        </tr>
                        <tr>
                            <td><b>Maths:</b> 800 <b>English:</b> 700</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="section-heading">
    Academic Record
</div>

<div class="info-nine-ten">
    <div class="info">
        <table>
            <tr>
                <td>9-10th Grade</td>
                <td>Qualifying Name:</td>
                <td>Secondary Education Examination, Nepal</td>
            </tr>
            <tr>
                <td>(Lower Secondary Leaving Examination)</td>
                <td>Awarding Body:</td>
                <td>National Examinations Board, Nepal</td>
            </tr>
        </table>
        <div class="desc">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus veritatis, blanditiis inventore
            iusto assumenda necessitatibus consequatur rerum modi vel fuga sit eligendi ullam, dolore quasi quas
            possimus libero voluptate dolor eius eveniet explicabo officia nihil beatae iste! Fugiat, quasi
            officiis. Ipsa commodi totam provident nulla est mollitia dolor, a magni fugiat ad dolorem illum
            assumenda nesciunt sit laboriosam laborum minus consequatur similique iusto! Blanditiis tempora,
            cumque totam quaerat deleniti optio.
        </div>
    </div>
    <div class="nine-ten">
        <table class="nine-ten-wrapping-table">
            <tr>
                <td>
                    <div class="nine">
                        <table>
                            <tr>
                                <td>Grade 9</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cource</td>
                                <td>Grade</td>
                            </tr>
EOT;
    $subjects = array(
        "English" => $data->nine_neb->english,
        "Nepali" => $data->nine_neb->nepali,
        "Maths" => $data->nine_neb->maths,
        "Science" => $data->nine_neb->science,
        "Social Studies" => $data->nine_neb->social,
        "HPE" => $data->nine_neb->hpe,
        "Omaths" => $data->nine_neb->omaths,
        "Computer" => $data->nine_neb->computer,
        "Economics" => $data->nine_neb->economics,
        "Geography" => $data->nine_neb->geography,
    );

    foreach ($subjects as $subject => $grade) {
        if ($grade !== "") { // Check if grade is not empty
            $html .= <<<EOT
                            <tr>
                                <td>$subject</td>
                                <td>$grade</td>
                            </tr>
                    EOT;
        }
    }
    $html .= <<<EOT
                        </table>
                    </div>
                </td>
                <td>
                    <div class="ten">
                        <table>
                            <tr>
                                <td>Grade 10</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cource</td>
                                <td>Grade</td>
                            </tr>
EOT;
    $subjects = array(
        "English" => $data->ten_neb->english,
        "Nepali" => $data->ten_neb->nepali,
        "Maths" => $data->ten_neb->maths,
        "Science" => $data->ten_neb->science,
        "Social Studies" => $data->ten_neb->social,
        "HPE" => $data->ten_neb->hpe,
        "Omaths" => $data->ten_neb->omaths,
        "Computer" => $data->ten_neb->computer,
        "Economics" => $data->ten_neb->economics,
        "Geography" => $data->ten_neb->geography,
    );

    foreach ($subjects as $subject => $grade) {
        if ($grade !== "") { // Check if grade is not empty
            $html .= <<<EOT
                            <tr>
                                <td>$subject</td>
                                <td>$grade</td>
                            </tr>
                    EOT;
        }
    }
    $html .= <<<EOT
                        </table>
                    </div>
                </td>
                <td>
                    <div class="grading-scale">
                        <table>
                            <tr>
                                <td>Scale</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="special">
                                <td>Absolute</td>
                                <td>Grade</td>
                                <td>Grade Point</td>
                                <td>Description</td>
                            </tr>
                            <tr>
                                <td>90-100</td>
                                <td>A+</td>
                                <td>4.0</td>
                                <td>Outstanding</td>
                            </tr>
                            <tr>
                                <td>80-89</td>
                                <td>A</td>
                                <td>3.6</td>
                                <td>Excellent</td>
                            </tr>
                            <tr>
                                <td>70-79</td>
                                <td>B+</td>
                                <td>3.2</td>
                                <td>Very Good</td>
                            </tr>
                            <tr>
                                <td>60-69</td>
                                <td>B</td>
                                <td>2.8</td>
                                <td>Good</td>
                            </tr>
                            <tr>
                                <td>50-59</td>
                                <td>C+</td>
                                <td>2.4</td>
                                <td>Satisfactory</td>
                            </tr>
                            <tr>
                                <td>40-49</td>
                                <td>C</td>
                                <td>2.0</td>
                                <td>Acceptable</td>
                            </tr>
                            <tr>
                                <td>30-39</td>
                                <td>D+</td>
                                <td>1.6</td>
                                <td>Partially Acceptable</td>
                            </tr>
                            <tr>
                                <td>20-29</td>
                                <td>D</td>
                                <td>1.2</td>
                                <td>Insufficient</td>
                            </tr>
                            <tr>
                                <td>0-19</td>
                                <td>E</td>
                                <td>0.8</td>
                                <td>Very Insufficient</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <p><b>9<sup>th</sup>-10<sup>th</sup> Grade GPA: {$data->ten_neb->gpa}</b></p>
</div>
<hr style="margin-top: 10px;">
EOT;

    if ($data->high_school_system == "NEB") {
        $html .= <<<EOT
<div class="info-nine-ten">
    <div class="info">
        <table>
            <tr>
                <td>11-12th Grade</td>
                <td>Qualifying Name:</td>
                <td>National Examinations Board, Nepal</td>
            </tr>
            <tr>
                <td>(Upper Secondary Leaving Examination)</td>
                <td>Awarding Body:</td>
                <td>National Examinations Board, Nepal</td>
            </tr>
        </table>
        <div class="desc">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus veritatis, blanditiis inventore
            iusto assumenda necessitatibus consequatur rerum modi vel fuga sit eligendi ullam, dolore quasi quas
            possimus libero voluptate dolor eius eveniet explicabo officia nihil beatae iste! Fugiat, quasi
            officiis. Ipsa commodi totam provident nulla est mollitia dolor, a magni fugiat ad dolorem illum
            assumenda nesciunt sit laboriosam laborum minus consequatur similique iusto! Blanditiis tempora,
            cumque totam quaerat deleniti optio.
        </div>
    </div>
    <div class="nine-ten">
        <table class="nine-ten-wrapping-table">
            <tr>
                <td>
                    <div class="nine">
                        <table>
                            <tr>
                                <td>Grade 11</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cource</td>
                                <td>Grade</td>
                            </tr>
EOT;
        $subjects = array(
            "English Th" => $data->eleven_neb->english,
            "English Pr" => $data->eleven_neb->english_pr,
            "Nepali Th" => $data->eleven_neb->nepali,
            "Nepali Pr" => $data->eleven_neb->nepali_pr,
            "Maths Th" => $data->eleven_neb->maths,
            "Maths Pr" => $data->eleven_neb->maths_pr,
            "Physics Th" => $data->eleven_neb->physics,
            "Physics Pr" => $data->eleven_neb->physics_pr,
            "Chemistry Th" => $data->eleven_neb->chemistry,
            "Chemistry Pr" => $data->eleven_neb->chemistry_pr,
            "Computer Th" => $data->eleven_neb->computer,
            "Computer Pr" => $data->eleven_neb->computer_pr,
            "Biology Th" => $data->eleven_neb->biology,
            "Biology Pr" => $data->eleven_neb->biology_pr
        );

        foreach ($subjects as $subject => $grade) {
            if ($grade !== "") { // Check if grade is not empty
                $html .= <<<EOT
        <tr>
            <td>$subject</td>
            <td>$grade</td>
        </tr>
EOT;
            }
        }
        $html .= <<<EOT
                        </table>
                    </div>
                </td>
                <td>
                    <div class="ten">
                        <table>
                            <tr>
                                <td>Grade 12</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cource</td>
                                <td>Grade</td>
                            </tr>
EOT;
        $subjects = array(
            "English Th" => $data->twelve_neb->english,
            "English Pr" => $data->twelve_neb->english_pr,
            "Nepali Th" => $data->twelve_neb->nepali,
            "Nepali Pr" => $data->twelve_neb->nepali_pr,
            "Maths Th" => $data->twelve_neb->maths,
            "Maths Pr" => $data->twelve_neb->maths_pr,
            "Physics Th" => $data->twelve_neb->physics,
            "Physics Pr" => $data->twelve_neb->physics_pr,
            "Chemistry Th" => $data->twelve_neb->chemistry,
            "Chemistry Pr" => $data->twelve_neb->chemistry_pr,
            "Computer Th" => $data->twelve_neb->computer,
            "Computer Pr" => $data->twelve_neb->computer_pr,
            "Biology Th" => $data->twelve_neb->biology,
            "Biology Pr" => $data->twelve_neb->biology_pr
        );

        foreach ($subjects as $subject => $grade) {
            if ($grade !== "") { // Check if grade is not empty
                $html .= <<<EOT
        <tr>
            <td>$subject</td>
            <td>$grade</td>
        </tr>
EOT;
            }
        }
        $html .= <<<EOT
                        </table>
                    </div>
                </td>
                <td>
                    <div class="grading-scale">
                        <table>
                            <tr>
                                <td>Scale</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="special">
                                <td>Absolute</td>
                                <td>Grade</td>
                                <td>Grade Point</td>
                                <td>Description</td>
                            </tr>
                            <tr>
                                <td>90-100</td>
                                <td>A+</td>
                                <td>4.0</td>
                                <td>Outstanding</td>
                            </tr>
                            <tr>
                                <td>80-89</td>
                                <td>A</td>
                                <td>3.6</td>
                                <td>Excellent</td>
                            </tr>
                            <tr>
                                <td>70-79</td>
                                <td>B+</td>
                                <td>3.2</td>
                                <td>Very Good</td>
                            </tr>
                            <tr>
                                <td>60-69</td>
                                <td>B</td>
                                <td>2.8</td>
                                <td>Good</td>
                            </tr>
                            <tr>
                                <td>50-59</td>
                                <td>C+</td>
                                <td>2.4</td>
                                <td>Satisfactory</td>
                            </tr>
                            <tr>
                                <td>40-49</td>
                                <td>C</td>
                                <td>2.0</td>
                                <td>Acceptable</td>
                            </tr>
                            <tr>
                                <td>30-39</td>
                                <td>D+</td>
                                <td>1.6</td>
                                <td>Partially Acceptable</td>
                            </tr>
                            <tr>
                                <td>20-29</td>
                                <td>D</td>
                                <td>1.2</td>
                                <td>Insufficient</td>
                            </tr>
                            <tr>
                                <td>0-19</td>
                                <td>E</td>
                                <td>0.8</td>
                                <td>Very Insufficient</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <p><b>11<sup>th</sup>-12<sup>th</sup> Grade GPA: {$data->twelve_neb->gpa}</b></p>
</div>
EOT;
    } else if (strtoupper($data->high_school_system) == "ALEVELS") {

        $html .= <<<EOT

        <div class="info-nine-ten">
    <div class="info">
        <table>
            <tr>
                <td>11-12th Grade</td>
                <td>Qualifying Name:</td>
                <td>General Certificate of Education Advanced Level (GCE A Level)<br>
                General Certificate of Education Advanced Subsidiary Level (GCE AS Level)
                </td>

            </tr>
            <tr>
                <td>(Upper Secondary Leaving Examination)</td>
                <td>Awarding Body:</td>
                <td>Cambridge Assessment International Education, UK</td>
            </tr>
        </table>
        <div class="desc">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloribus veritatis, blanditiis inventore
            iusto assumenda necessitatibus consequatur rerum modi vel fuga sit eligendi ullam, dolore quasi quas
            possimus libero voluptate dolor eius eveniet explicabo officia nihil beatae iste! Fugiat, quasi
            officiis. Ipsa commodi totam provident nulla est mollitia dolor, a magni fugiat ad dolorem illum
            assumenda nesciunt sit laboriosam laborum minus consequatur similique iusto! Blanditiis tempora,
            cumque totam quaerat deleniti optio.
        </div>
    </div>
    <div class="nine-ten">
    <table class="nine-ten-wrapping-table">
        <tr>
            <td>
                <div class="nine">
                    <table>
                        <tr>
                            <td>A Levels</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Course</td>
                            <td>Grade</td>
                        </tr>
EOT;

        $subjects = array(
            "General Paper" => $data->aggregate_alevels->general_paper,
            "English" => $data->aggregate_alevels->elang,
            "Mathematics" => $data->aggregate_alevels->maths,
            "Physics" => $data->aggregate_alevels->physics,
            "Chemistry" => $data->aggregate_alevels->chemistry,
            "Business" => $data->aggregate_alevels->business,
            "Economics" => $data->aggregate_alevels->economics,
            "Accountancy" => $data->aggregate_alevels->accounting,
            "Computer Science" => $data->aggregate_alevels->computer,
            "Biology" => $data->aggregate_alevels->biology,
            "Further Mathematics" => $data->aggregate_alevels->further_maths,
        );

        foreach ($subjects as $subject => $grade) {
            if ($grade !== "") { // Check if grade is not empty
                $html .= <<<EOT
                        <tr>
                            <td>$subject</td>
                            <td>$grade</td>
                        </tr>
EOT;
            }
        }

        $html .= <<<EOT
                    </table>
                </div>
            </td>
            <td>
                <div class="grading-scale">
                    <table>
                        <tr>
                            <td>Scale</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="special">
                            <td>A Level Grade</td>
                            <td>PUM Range</td>
                            <td>AS Level Grade</td>
                            <td>PUM Range</td>
                        </tr>
                        <tr>
                            <td>A*</td>
                            <td>90-100</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>80-89</td>
                            <td>a</td>
                            <td>80-100</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>70-79</td>
                            <td>b</td>
                            <td>70-79</td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td>60-69</td>
                            <td>c</td>
                            <td>60-69</td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td>50-59</td>
                            <td>d</td>
                            <td>50-59</td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td>40-49</td>
                            <td>e</td>
                            <td>40-49</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</div>
<p><b>11<sup>th</sup>-12<sup>th</sup> Grade GPA: {$data->aggregate_alevels->gpa}</b></p>
</div>
<div class="sign-area">
<table>
    <!-- Additional table content -->
</table>
</div>
EOT;
    }
    $html .= <<<EOT
<hr style="margin-top: 10px;">
<div class="sign-area">
    <table style="margin-left: 150px;">
        <tr>
            <td style="width: 250px;">
                I do hereby certify and affirm that this is the official transcript and record of Nikas Ghimire as of
                May 2021.
            </td>
            <td>
                <div class="sign">
                    <hr>
                    H.N Acharya
                    <br>
                    Principal
                </div>
            </td>
            <td>
                <!-- a box to sign -->
                <table border=1 style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 30px;">SEAL</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
EOT;
    return $html;
}
