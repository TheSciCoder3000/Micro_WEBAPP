<?php
    $serverName="NeurosLaptop\SQLEXPRESS";

    $connectionOptions=[
        "Database"=>"WEBAPP",
        "Uid"=>"",
        "PWD"=>""
    ];

    $conn=sqlsrv_connect($serverName, $connectionOptions);

    $sql = "SELECT STUDENT_NUMBER FROM STUDENT WHERE STUDENT_NUMBER = (SELECT IDENT_CURRENT('STUDENT'));";
    $results=sqlsrv_query($conn, $sql);

    $userid = sqlsrv_fetch_array($results);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registration Successful</h1>
    <h2>Your User Id: <?php echo $userid['STUDENT_NUMBER']; ?></h2>
</body>
</html>