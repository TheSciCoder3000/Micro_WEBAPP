<?php
$serverName = "NeurosLaptop\SQLEXPRESS";
$connectionOptions = [
    "database" => "WEBAPP"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

$sql = "SELECT * FROM PDF_UPLOAD WHERE PDF_ID = 2000;";
$res = sqlsrv_query($conn, $sql);
$file_path = sqlsrv_fetch_array($res)['PDF_PATH'];

if ($res) {
    header('Content-type: application/octet-stream');
    header("Content-Transfer-encoding: utf-8");
    header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\"");
}
