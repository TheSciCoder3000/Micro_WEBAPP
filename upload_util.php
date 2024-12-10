<?php

print_r($_FILES);

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type_1 = $finfo->file($_FILES['file-1']['tmp_name']);
$mime_type_full = $finfo->file($_FILES['file-full']['tmp_name']);

$mime_types = ["application/pdf"];

if (!in_array($_FILES['file-1']['type'], $mime_types) && !in_array($_FILES['file-full']['type'], $mime_types)) {
    exit("File type not supported");
}


$filename_1 = $_FILES['file-1']['name'];
$filesize_1 = $_FILES['file-1']['size'];
$destination_1 = __DIR__ . '\uploads/' . $filename_1;

$filename_full = $_FILES['file-full']['name'];
$filesize_full = $_FILES['file-full']['size'];
$destination_full = __DIR__ . '\uploads/' . $filename_full;

$upload_success_1 = move_uploaded_file($_FILES['file-1']['tmp_name'], $destination_1);
$upload_success_full = move_uploaded_file($_FILES['file-full']['tmp_name'], $destination_full);



$serverName = "NeurosLaptop\SQLEXPRESS";

$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

$sql_title = "SELECT * FROM TITLE WHERE TITLE_ID = (SELECT IDENT_CURRENT('TITLE'));";
$title_res = sqlsrv_query($conn, $sql_title);
$title_id = sqlsrv_fetch_array($title_res)['TITLE_ID'];

$sql_res_1 = false;
$sql_res_full = false;

if ($_FILES['file-1']['error'] == 0) {
    $sql = "INSERT INTO PDF_ABSTRACT (PDF_NAME, PDF_SIZE, PDF_PATH, TITLE_ID) 
            VALUES ('$filename_1', '$filesize_1', '$destination_1', '$title_id');";
    $sql_res_1 = sqlsrv_query($conn, $sql);
}

if ($_FILES['file-full']['error'] == 0) {
    $sql = "INSERT INTO PDF_FULL (PDF_NAME, PDF_SIZE, PDF_PATH, TITLE_ID) 
            VALUES ('$filename_full', '$filesize_full', '$destination_full', '$title_id');";
    $sql_res_full = sqlsrv_query($conn, $sql);
}

if ($sql_res_1 && $sql_res_full) {
    echo "<br>Uploaded successful to the db";
    header('Location: success.php');
} else {
    echo "<br>error: db upload";
}
