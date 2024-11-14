<?php
header('Access-Control-Allow-Headers: *');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    die();
}

$serverName="NeurosLaptop\SQLEXPRESS";

$connectionOptions=[
    "Database"=>"WEBAPP",
    "Uid"=>"",
    "PWD"=>""
];

$conn=sqlsrv_connect($serverName, $connectionOptions);



$json = file_get_contents('php://input');


$data = json_decode($json, true);


if (json_last_error() === JSON_ERROR_NONE) {
    // ============================ TITLE ============================
    $title_name=$data['thesis-title'];
    $program=$data['program'];
    $co_program=$data['co-program'];
    $school_year=$data['school-year'];
    $date_of_submission=$data['date-of-submission'];
    $subject=$data['subject-study'];

    $title_sql="INSERT INTO TITLE (TITLE_NAME, PROGRAM, CO_PROGRAM, SCHOOL_YEAR, DATE_OF_SUBMISSION, SUBJECT) VALUES ('$title_name', '$program', '$co_program', '$school_year', '$date_of_submission', '$subject'); SELECT SCOPE_IDENTITY()";
    $title_results=sqlsrv_query($conn, $title_sql);

    sqlsrv_next_result($title_results); 
    sqlsrv_fetch($title_results); 
    $title_id = sqlsrv_get_field($title_results, 0); 

    // ============================ AUTHORS ============================
    $authors = $data['authors'];
    foreach ($authors as $author) {
        $first = $author['first'];
        $middle = $author['middle'];
        $last = $author['last'];

        $author_sql="INSERT INTO AUTHOR(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$last', '$first', '$middle', $title_id);";
        $author_results=sqlsrv_query($conn, $author_sql);

        if($author_results) {
            echo "registration successful: AUTHOR\n";
        } else {
            echo "something went wrong: AUTHOR\n";
        }
    }

    // ============================ ADVISER ============================
    $adviser = $data['adviser'];
    $adviser_last=$adviser['last'];
    $adviser_first=$adviser['first'];
    $adviser_middle=$adviser['middle'];

    $adviser_sql="INSERT INTO ADVISER(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$adviser_last', '$adviser_first', '$adviser_middle', $title_id);";
    $adviser_results=sqlsrv_query($conn, $adviser_sql);

    // ============================ COADVISER ============================
    $co_adviser = $data['co-adviser'];
    if ($co_adviser) {
        $co_adviser_last=$co_adviser['last'];
        $co_adviser_first=$co_adviser['first'];
        $co_adviser_middle=$co_adviser['middle'];
    
        $co_adviser_sql="INSERT INTO CO_ADVISER(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$co_adviser_last', '$co_adviser_first', '$co_adviser_middle', $title_id);";
        $co_adviser_results=sqlsrv_query($conn, $co_adviser_sql);
    }


    // ============================ CONTACT ============================
    $phone_number=$data['contact-number'];
    $email=$data['contact-email'];

    $contact_sql="INSERT INTO CONTACT(PHONE_NUMBER, EMAIL, TITLE_ID) VALUES ($phone_number, '$email', $title_id);";
    $contact_results=sqlsrv_query($conn, $contact_sql);

    http_response_code(200);

} else {
    http_response_code(400);
    echo "Invalid JSON data.";
}