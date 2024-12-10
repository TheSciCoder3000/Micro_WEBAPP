<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <title>Login</title>
</head>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = md5($password);

    $serverName = "NeurosLaptop\SQLEXPRESS";

    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    $login_sql = "SELECT * FROM ADMIN_LOGIN WHERE USERNAME = '$username' AND PASSWORD = '$hashed_password'";
    $login_res = sqlsrv_query($conn, $login_sql);
    $logins = sqlsrv_fetch_array($login_res);

    if (isset($logins['USERID'])) {
        header('Location: reports.php');
    }
}
?>

<body>
    <svg class="eclipse-bl" width="550" height="491" viewBox="0 0 550 491" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="163.533" cy="372.97" rx="415.428" ry="339.59" transform="rotate(-39.8844 163.533 372.97)" fill="#1FAB89" />
    </svg>
    <svg class="eclipse-tr" width="280" height="381" viewBox="0 0 280 381" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="326.979" cy="62.8372" rx="345.178" ry="296.472" transform="rotate(-39.8844 326.979 62.8372)" fill="#1FAB89" />
    </svg>

    <div class="login-modal">
        <div class="img-cont">
            <img src="./img/login-img.jpg" alt="">
        </div>
        <div class="login-form-cont">
            <div class="form-navigation">
                <button onclick="history.back()" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                    </svg>
                    Back
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <h1>Login</h1>
                <div class="field-cont">
                    <input type="text" id="username" name="username" autocomplete="off" required>
                    <label for="username">Username</label>
                    <div class="underline"></div>
                </div>
                <div class="field-cont">
                    <input type="password" id="password" name="password" autocomplete="off" required>
                    <label for="password">Password</label>
                    <div class="underline"></div>
                    <button onclick="showPassword()" type="button" class="show-btn" id="show-btn">
                        show
                    </button>
                </div>
                <input type="submit" name="submit" value="LOGIN">
            </form>
        </div>
    </div>

    <script>
        function showPassword() {
            let passwordInput = document.getElementById('password');
            let isShown = passwordInput.getAttribute('type') == 'text';
            if (isShown) {
                passwordInput.setAttribute('type', 'password');
                document.getElementById('show-btn').classList.remove('active');
            } else {
                passwordInput.setAttribute('type', 'text');
                document.getElementById('show-btn').classList.add('active');
            }

        }
    </script>
</body>

</html>