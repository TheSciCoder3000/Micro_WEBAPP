<?php

$serverName="NeurosLaptop\SQLEXPRESS";

$connectionOptions=[
    "Database"=>"WEBAPP",
    "Uid"=>"",
    "PWD"=>""
];

$conn=sqlsrv_connect($serverName, $connectionOptions);

$student_name=$_POST['student-name'];
$student_email=$_POST['student-email'];
$year_level=$_POST['year-level'];
$mobile_number=$_POST['mobile-number'];

$sql="INSERT INTO STUDENT(STUDENT_NAME, STUDENT_EMAIL, YEAR_LEVEL, MOBILE_NUMBER) VALUES ('$student_name', '$student_email', $year_level, $mobile_number);";
$results=sqlsrv_query($conn, $sql);

if($results) {
    echo "registration successful";
} else {
    echo "something went wrong";
}