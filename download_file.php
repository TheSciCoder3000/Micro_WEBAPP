<?php

$file_path = $_POST['file-path'];
header('Content-type: application/octet-stream');
header("Content-Transfer-encoding: utf-8");
header("Content-disposition: attachment; filename=\"" . basename($file_path) . "\"");
header("Content-length: " . filesize($file_path));
readfile($file_path);
flush();
