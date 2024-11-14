<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>


<body>
    <h1>Login Form</h1>
    <p>login your credentials</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div>
            <label for="">Login ID</label>
            <input type="text" name="login-id" id="login-id">
        </div>
        <div>
            <label for="">Password</label>
            <input type="text" name="password" id="password">
        </div>
        <div>
            <label for="">Retype Password</label>
            <input type="text" name="retype-password" id="retype-password">
        </div>
        <input type="submit" value="LOGIN" name="submit">

        <div>
            <?php

            if (isset($_POST['submit'])) {
                $password = $_POST['password'];
                $retypePassword = $_POST['retype-password'];

                if ($password != $retypePassword) {
                    echo "Error: password and retype password are not the same";
                } else {
                    $serverName = "NeurosLaptop\SQLEXPRESS";

                    $connectionOptions = [
                        "Database" => "WEBAPP",
                        "Uid" => "",
                        "PWD" => ""
                    ];

                    $loginId = $_POST['login-id'];
                    $hashPassword = md5($_POST['password']);
                    $conn = sqlsrv_connect($serverName, $connectionOptions);
                    $sql = "INSERT INTO LOGIN (LOGINID, PASSWORD) VALUES ('$loginId', '$hashPassword');";
                    $result = sqlsrv_query($conn, $sql);

                    if ($result) echo "Login credentials created";
                }
            }

            ?>
        </div>

    </form>
</body>

</html>