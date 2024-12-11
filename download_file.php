<?php
$serverName = "NeurosLaptop\SQLEXPRESS";
$connectionOptions = [
    "database" => "WEBAPP"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);

$file_path = $_POST['file-path'];
header('Content-type: application/octet-stream');
header("Content-Transfer-encoding: utf-8");
header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\"");
