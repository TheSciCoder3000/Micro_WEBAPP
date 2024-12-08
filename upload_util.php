<?php

print_r($_FILES);

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($_FILES['file']['tmp_name']);

$mime_types = ["application/pdf"];

if (!in_array($_FILES['file']['type'], $mime_types)) {
    exit("File type not supported");
}

$filename = $_FILES['file']['name'];
$destination = __DIR__ . "\uploads/" . $filename;
$filesize = $_FILES['file']['size'];

$upload_success = move_uploaded_file($_FILES['file']['tmp_name'], $destination);

if ($_FILES['file']['error'] == 0) {
    echo "Upload success";

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

    $sql = "INSERT INTO PDF_UPLOAD (PDF_NAME, PDF_SIZE, PDF_PATH, TITLE_ID) 
            VALUES ('$filename', '$filesize', '$destination', '$title_id');";
    $sql_res = sqlsrv_query($conn, $sql);

    if ($sql_res) {
        echo "<br>Uploaded successful to the db";
        header('Location: success.php');
    } else {
        echo "<br>error: db upload";
    }
}
