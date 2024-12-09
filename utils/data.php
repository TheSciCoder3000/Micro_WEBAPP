<?php

function is_value_empty(String $value)
{
    $trimmed_str = trim($value);
    if ($trimmed_str === null || $trimmed_str == "") return false;
    return true;
}

$PROGRAMS = [
    'CPE' => 'Bachelor of Science in Computer Engineering',
    'MEE' => 'Bachelor of Science in Mechanical Engineering',
    'ECE' => 'Bachelor of Science in Electrical Engineering',
    'IE' => 'Bachelor of Science in Industrial Engineering',
    'CE' => 'Bachelor of Science in Civil Engineering',
    'MMA' => 'Bachelor of Multimedia Arts',
    'ARC' => 'Bachelor of Science in Architecture',
];

$SUBJECTS = [
    'Technology',
    'Biology',
    'Physics',
    'Chemistry',
    'Geology',
    'Environmental Science',
    'Oceanology',
    'Mathematics',
    'Statistics',
    'Computer Science',
    'Logic',
    'Information Theory',
    'Engineering',
    'Medicine',
    'Agriculture',
    'Mental Health',
    'Health Policy',
    'Data Science',
    'Artificial Intelligence',
];
