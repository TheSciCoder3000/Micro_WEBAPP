<?php

$serverName = "NeurosLaptop\SQLEXPRESS";
$connectionOptions = [
    "database" => "WEBAPP"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

// $sql = "SELECT * FROM PDF_UPLOAD WHERE PDF_ID = 2000;";
// $res = sqlsrv_query($conn, $sql);
$file_path = $_POST['file-path']; // sqlsrv_fetch_array($res)['PDF_PATH'];
print_r($file_path);
print_r(filesize("C:\xampp\htdocs\webapp\uploads/1Y1S.pdf"));
// header("Content-type: application/pdf");
// header("Content-length: " . filesize($file_path));
// readfile($file_path);
