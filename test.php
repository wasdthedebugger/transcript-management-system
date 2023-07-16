<?php

function highSchoolNebGPA($english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr)
{
    $subjects = array(
        'english' => 3,
        'english_pr' => 1,
        'nepali' => 2.25,
        'nepali_pr' => 0.75,
        'maths' => 3.75,
        'maths_pr' => 1.25,
        'physics' => 3.75,
        'physics_pr' => 1.25,
        'chemistry' => 3.75,
        'chemistry_pr' => 1.25,
        'computer' => 2.5,
        'computer_pr' => 2.5,
        'biology' => 3.25,
        'biology_pr' => 1.75
    );

    $grades = array(
        'english' => $english,
        'english_pr' => $english_pr,
        'nepali' => $nepali,
        'nepali_pr' => $nepali_pr,
        'maths' => $maths,
        'maths_pr' => $maths_pr,
        'physics' => $physics,
        'physics_pr' => $physics_pr,
        'chemistry' => $chemistry,
        'chemistry_pr' => $chemistry_pr,
        'computer' => $computer,
        'computer_pr' => $computer_pr,
        'biology' => $biology,
        'biology_pr' => $biology_pr
    );

    $validGrades = array();
    $totalCreditHours = 0;

    foreach ($subjects as $subject => $creditHour) {
        if (isset($grades[$subject])) {
            $grade = $grades[$subject];
            if ($grade !== '') {
                if ($grade == 0) {
                    return 0; // Return 0 GPA if any subject has a grade of 0
                }
                if ($grade !== '') {
                    $validGrades[] = $grade * $creditHour;
                    $totalCreditHours += $creditHour;
                }
            }
        }
    }

    if (empty($validGrades)) {
        return 0; // Return 0 GPA if no valid grades found
    }

    $gpa = array_sum($validGrades) / $totalCreditHours;
    return $gpa;
}

// Example usage
$english = ''; // Replace with actual grade for English
$english_pr = 1; // Replace with actual grade for English Practical
$nepali = 2.25; // Replace with actual grade for Nepali
$nepali_pr = 0.75; // Replace with actual grade for Nepali Practical
$maths = 3.75; // Replace with actual grade for Maths
$maths_pr = 1.25; // Replace with actual grade for Maths Practical
$physics = 3.75; // Replace with actual grade for Physics
$physics_pr = 1.25; // Replace with actual grade for Physics Practical
$chemistry = 3.75; // Replace with actual grade for Chemistry
$chemistry_pr = 1.25; // Replace with actual grade for Chemistry Practical
$computer = 2.5; // Replace with actual grade for Computer
$computer_pr = 2.5; // Replace with actual grade for Computer Practical
$biology = 3.25; // Replace with actual grade for Biology
$biology_pr = 1.75; // Replace with actual grade for Biology Practical

$result = highSchoolNebGPA($english, $english_pr, $nepali, $nepali_pr, $maths, $maths_pr, $physics, $physics_pr, $chemistry, $chemistry_pr, $computer, $computer_pr, $biology, $biology_pr);
echo "GPA: " . $result;
