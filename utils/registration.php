<?php

function connectDb()
{
    $serverName = "NeurosLaptop\SQLEXPRESS";

    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    return $conn;
}

function isCoAdviserValid()
{
    $LastEmpty = empty($_POST['co-adviser-last']);
    $FirstEmpty = empty($_POST['co-adviser-first']);
    $MidEmpty = empty($_POST['co-adviser-middle']);

    // print_r([$LastEmpty && $FirstEmpty && $MidEmpty, !$LastEmpty && !$FirstEmpty && !$MidEmpty]);
    if ($LastEmpty && $FirstEmpty && $MidEmpty) {
        return true;
    } else if (!$LastEmpty && !$FirstEmpty && !$MidEmpty) {
        return true;
    } else {
        return false;
    }
}

function checkTitle($conn, $title)
{
    $sql = "SELECT TITLE_ID FROM TITLE WHERE CONVERT(VARCHAR, TITLE_NAME) = '$title';";
    $sql_results = sqlsrv_query($conn, $sql);

    $thesi = [];
    while ($results = sqlsrv_fetch_array($sql_results)) {
        $thesi[] = $results[0];
    }
    return $thesi;
}

function checkAuthors()
{
    $same = false;
    $authors = [];
    foreach ($_POST as $field => $value) {

        if (strpos($field, "author") !== false) {
            $authorArray = explode("-", $field);
            $authors[$authorArray[1]][$authorArray[2]] = $value;
        }
    }

    $authorsParsed = [];
    foreach ($authors as $key => $data) {
        $last = $data['last'];
        $first = $data['first'];
        $middle = $data['middle'];

        if (in_array("$last $first $middle", $authorsParsed)) {
            $same = true;
        } else {
            $authorsParsed[] = "$last $first $middle";
        }
    }

    return $same;
}

function insertToDb($conn)
{
    $title_name = $_POST['thesis-title'];
    $program = $_POST['program'];
    $co_program = $_POST['co-program'];
    $school_year = $_POST['school-year'];
    $date_of_submission = $_POST['date-of-submission'];
    $subject = $_POST['subject-study'];

    $title_sql = "INSERT INTO TITLE (TITLE_NAME, PROGRAM, CO_PROGRAM, SCHOOL_YEAR, DATE_OF_SUBMISSION, SUBJECT) VALUES ('$title_name', '$program', '$co_program', '$school_year', '$date_of_submission', '$subject');";
    $title_results = sqlsrv_query($conn, $title_sql);

    $title_id_query = "SELECT TITLE_ID FROM TITLE WHERE TITLE_ID = (SELECT IDENT_CURRENT('TITLE'));";
    $title_id_results = sqlsrv_query($conn, $title_id_query);
    $title_id = sqlsrv_fetch_array($title_id_results)['TITLE_ID'];

    $authors = [];
    foreach ($_POST as $field => $value) {

        if (strpos($field, "author") !== false) {
            $authorArray = explode("-", $field);
            $authors[$authorArray[1]][$authorArray[2]] = $value;
        }
    }

    foreach ($authors as $data) {
        $last = $data['last'];
        $first = $data['first'];
        $middle = $data['middle'];

        $author_sql = "INSERT INTO AUTHOR(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$last', '$first', '$middle', $title_id);";
        $author_results = sqlsrv_query($conn, $author_sql);
    }


    $adviser_last = $_POST['adviser-last'];
    $adviser_first = $_POST['adviser-first'];
    $adviser_middle = $_POST['adviser-middle'];

    $adviser_sql = "INSERT INTO ADVISER(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$adviser_last', '$adviser_first', '$adviser_middle', $title_id);";
    $adviser_results = sqlsrv_query($conn, $adviser_sql);


    $co_adviser_last = $_POST['co-adviser-last'];
    $co_adviser_first = $_POST['co-adviser-first'];
    $co_adviser_middle = $_POST['co-adviser-middle'];
    if (!empty($co_adviser_first) && !empty($co_adviser_middle) && !empty($co_adviser_last)) {
        $co_adviser_sql = "INSERT INTO CO_ADVISER(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$co_adviser_last', '$co_adviser_first', '$co_adviser_middle', $title_id);";
        $co_adviser_results = sqlsrv_query($conn, $co_adviser_sql);
    }



    $phone_number = $_POST['contact-number'];
    $email = $_POST['contact-email'];

    $contact_sql = "INSERT INTO CONTACT(PHONE_NUMBER, EMAIL, TITLE_ID) VALUES ($phone_number, '$email', $title_id);";
    $contact_results = sqlsrv_query($conn, $contact_sql);

    if (!empty($title_results) && !empty($adviser_results) && !empty($contact_results)) {
        header("Location: success.php");
    }
}
