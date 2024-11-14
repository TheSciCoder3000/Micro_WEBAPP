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

function updateDb($conn, $title_id)
{
    $title_name = $_POST['thesis-title'];
    $program = $_POST['program'];
    $co_program = $_POST['co-program'];
    $school_year = $_POST['school-year'];
    $date_of_submission = $_POST['date-of-submission'];
    $subject = $_POST['subject-study'];

    // ============================================== UPDATE TITLE ==============================================
    $title_sql = "UPDATE TITLE SET TITLE_NAME = '$title_name', PROGRAM = '$program', CO_PROGRAM = '$co_program', SCHOOL_YEAR = '$school_year', DATE_OF_SUBMISSION = '$date_of_submission', SUBJECT = '$subject' WHERE TITLE_ID = $title_id;";
    $title_results = sqlsrv_query($conn, $title_sql);

    // ============================================== UPDATE AUTHORS ==============================================
    $orig_author_sql = "SELECT AUTHOR_ID FROM AUTHOR WHERE TITLE_ID = $title_id;";
    $orig_author_query = sqlsrv_query($conn, $orig_author_sql);
    $orig_authors = [];
    while ($row = sqlsrv_fetch_array($orig_author_query)) $orig_authors[] = $row['AUTHOR_ID'];

    $authors = [];
    foreach ($_POST as $field => $value) {

        if (strpos($field, "author") !== false) {
            $authorArray = explode("-", $field);
            $authors[$authorArray[1]][$authorArray[2]] = $value;
        }
    }

    // Update authors
    foreach ($authors as $author_id => $data) {
        $last = $data['last'];
        $first = $data['first'];
        $middle = $data['middle'];

        if (in_array($author_id, $orig_authors)) {
            $author_sql = "UPDATE AUTHOR SET LAST_NAME = '$last', FIRST_NAME = '$first', MIDDLE_NAME = '$middle' WHERE AUTHOR_ID = $author_id;";
            $author_results = sqlsrv_query($conn, $author_sql);
        } else {
            $author_sql = "INSERT INTO AUTHOR(LAST_NAME, FIRST_NAME, MIDDLE_NAME, TITLE_ID) VALUES ('$last', '$first', '$middle', $title_id);";
            $author_results = sqlsrv_query($conn, $author_sql);
        }
    }

    // Delete removed authors
    foreach ($orig_authors as $orig_item) {
        if (!in_array($orig_item, array_keys($authors))) {
            $delete_author_sql = "DELETE FROM AUTHOR WHERE AUTHOR_ID = $orig_item;";
            $delete_author_query = sqlsrv_query($conn, $delete_author_sql);
        }
    }

    // ============================================== UPDATE ADVISER ==============================================
    $adviser_last = $_POST['adviser-last'];
    $adviser_first = $_POST['adviser-first'];
    $adviser_middle = $_POST['adviser-middle'];

    $adviser_sql = "UPDATE ADVISER SET LAST_NAME = '$adviser_last', FIRST_NAME = '$adviser_first', MIDDLE_NAME = '$adviser_middle' WHERE TITLE_ID = $title_id;";
    $adviser_results = sqlsrv_query($conn, $adviser_sql);


    // ============================================== UPDATE CO ADVISER ==============================================
    $co_adviser_last = $_POST['co-adviser-last'];
    $co_adviser_first = $_POST['co-adviser-first'];
    $co_adviser_middle = $_POST['co-adviser-middle'];
    $co_adviser_sql = "UPDATE CO_ADVISER SET LAST_NAME = '$co_adviser_last', FIRST_NAME = '$co_adviser_first', MIDDLE_NAME = '$co_adviser_middle' WHERE TITLE_ID = $title_id;";
    $co_adviser_query = sqlsrv_query($conn, $co_adviser_sql);


    $phone_number = $_POST['contact-number'];
    $email = $_POST['contact-email'];

    $contact_sql = "UPDATE CONTACT SET PHONE_NUMBER = $phone_number, EMAIL = '$email' WHERE TITLE_ID = $title_id;";
    $contact_results = sqlsrv_query($conn, $contact_sql);

    if (!empty($title_results) && !empty($adviser_results) && !empty($contact_results)) {
        header("Location: confirm.php");
    }
}

function getData($conn)
{
    $data = [];
    $sql = "SELECT * FROM TITLE WHERE TITLE_ID = (SELECT IDENT_CURRENT('TITLE'));";
    $results = sqlsrv_query($conn, $sql);
    $thesis = sqlsrv_fetch_array($results);

    $title_id = $thesis['TITLE_ID'];

    $title_sql = "SELECT * FROM TITLE WHERE TITLE_ID = $title_id";
    $title_results = sqlsrv_query($conn, $title_sql);
    $title_dict = sqlsrv_fetch_array($title_results);
    if ($title_results && $title_dict) {
        $data = array_merge($data, $title_dict);
    }

    $authors_sql = "SELECT * FROM AUTHOR WHERE TITLE_ID = $title_id";
    $authors_results = sqlsrv_query($conn, $authors_sql);
    if ($authors_results) {
        while ($row = sqlsrv_fetch_array($authors_results)) {
            $data['AUTHORS'][] = $row;
        }
    }

    $adviser_sql = "SELECT * FROM ADVISER WHERE TITLE_ID = $title_id";
    $adviser_results = sqlsrv_query($conn, $adviser_sql);
    $adviser_dict = sqlsrv_fetch_array($adviser_results);

    if ($adviser_results && $adviser_dict) {
        $data['ADVISER_ID'] = $adviser_dict['ADVISER_ID'];
        $data['ADVISER_FIRST'] = $adviser_dict['FIRST_NAME'];
        $data['ADVISER_LAST'] = $adviser_dict['LAST_NAME'];
        $data['ADVISER_MIDDLE'] = $adviser_dict['MIDDLE_NAME'];
    }

    $co_adviser_sql = "SELECT * FROM CO_ADVISER WHERE TITLE_ID = $title_id";
    $co_adviser_results = sqlsrv_query($conn, $co_adviser_sql);
    $co_adviser_dict = sqlsrv_fetch_array($co_adviser_results);

    if ($co_adviser_results && $co_adviser_dict) {
        $data['CO_ADVISER_ID'] = $co_adviser_dict['CO_ID'];
        $data['CO_ADVISER_FIRST'] = $co_adviser_dict['FIRST_NAME'];
        $data['CO_ADVISER_LAST'] = $co_adviser_dict['LAST_NAME'];
        $data['CO_ADVISER_MIDDLE'] = $co_adviser_dict['MIDDLE_NAME'];
    }

    $contact_sql = "SELECT * FROM CONTACT WHERE TITLE_ID = $title_id";
    $contact_results = sqlsrv_query($conn, $contact_sql);
    $contact_dict = sqlsrv_fetch_array($contact_results);
    if ($contact_results && $contact_dict) {
        $data['CONTACT_ID'] = $contact_dict['CONTACT_ID'];
        $data['EMAIL'] = $contact_dict['EMAIL'];
        $data['PHONE_NUMBER'] = $contact_dict['PHONE_NUMBER'];
    }

    return $data;
}

function displayAuthors($authors)
{

    foreach ($authors as $key => $author) {
        $authorNo = $key + 1;
        echo "
            <div class=\"field-container\">
                <div class=\"label-container flex\">
                    <label>Author {$authorNo}</label>
                    <button onclick=\"removeAuthorV2()\" type=\"button\" class=\"remove-btn\">
                        <svg viewBox=\"0 0 448 512\"><path d=\"M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z\"></path></svg>
                    </button>
                </div>
                <div class=\"flex\">
                    <input value=\"{$author['LAST_NAME']}\" class=\"full\" type=\"text\" id=\"author-2-last\" name=\"author-{$author['AUTHOR_ID']}-last\" placeholder=\"Last Name\" required>
                    <input value=\"{$author['FIRST_NAME']}\" class=\"full\" type=\"text\" id=\"author-2-first\" name=\"author-{$author['AUTHOR_ID']}-first\" placeholder=\"First Name\" required>
                    <input value=\"{$author['MIDDLE_NAME']}\" class=\"full\" type=\"text\" id=\"author-2-middle\" name=\"author-{$author['AUTHOR_ID']}-middle\" placeholder=\"Middle Name\" required>
                </div>
            </div>
        ";
    }
}
