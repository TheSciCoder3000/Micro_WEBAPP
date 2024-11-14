<?php
$serverName = "NeurosLaptop\SQLEXPRESS";
$connectionOptions = [
    "database" => "DLSU"
];
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn == false)
    die(print_r(sqlsrv_errors(), true));
else echo 'Connection Success';
