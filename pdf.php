    <?php

    require('includes/conn.php');
    require('vendor/autoload.php');
    require('includes/conn.php');
    $roll_no = $_GET['roll_no'];
    $sql = "SELECT * FROM students WHERE roll_no = '$roll_no'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $last_name = $row['last_name'];
    $dob = $row['dob'];
    $district = $row['district'];
    $municipality = $row['municipality'];
    $provience = $row['provience'];
    $sex = $row['sex'];


    use Mpdf\Mpdf;

    $pdf = new Mpdf();
    $pdf->SetMargins(0, 0, 7, 0);
    $pdf->WriteHTML(generateHTML($roll_no, $first_name, $middle_name, $last_name, $dob, $sex,  $district, $municipality, $provience));

    $pdf->Output();

    function generateHTML($roll_no, $first_name, $middle_name, $last_name, $dob, $sex, $municipality, $district, $provience)
    {
        return <<<EOT
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
                font-size: 0.7em;
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
                                <td>$first_name $middle_name $last_name</td>
                                <td>$dob</td>
                                <td>$sex</td>
                            </tr>
                            <tr class="bold-tr">
                                <td>Municipality</td>
                                <td>District</td>
                                <td>Province</td>
                            </tr>
                            <tr>
                                <td>$municipality</td>
                                <td>$district</td>
                                <td>$provience</td>
                            </tr>
                            <tr class="bold-tr">
                                <td>Roll Number: $roll_no</td>
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
                                <td><b>Graduating Class Rank (projected if not graduated): 9/101</b></td>
                            </tr>
                            <tr>
                                <td><b>Sat (If avaiable):</b></td>
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
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Social studies</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="ten">
                            <table>
                                <tr>
                                    <td>Grade 9</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Cource</td>
                                    <td>Grade</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
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
        <p><b>9<sup>th</sup>-10<sup>th</sup> Grade GPA: 4.0</b></p>
    </div>
    <hr style="margin-top: 10px;">
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
                                    <td>Grade 9</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Cource</td>
                                    <td>Grade</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Social studies</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="ten">
                            <table>
                                <tr>
                                    <td>Grade 9</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Cource</td>
                                    <td>Grade</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>English</td>
                                    <td>A</td>
                                </tr>
                                <tr>
                                    <td>Nepali</td>
                                    <td>A</td>
                                </tr>
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
        <p><b>9<sup>th</sup>-10<sup>th</sup> Grade GPA: 4.0</b></p>
    </div>
    <hr>
    <div class="sign-area">
        <table style="margin-left: 100px;">
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
    }
