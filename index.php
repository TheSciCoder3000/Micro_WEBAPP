<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Dashboard.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <title>Dashboard</title>
</head>

<body>
    <nav>
        <div class="logo-cont">
            <img src="./img/dlsud-logo.png" alt="dlsud-logo">
            <h2>University Thesis Inventory</h2>
        </div>
        <ul class="nav-list">
            <li class="nav-item active">Dashboard</li>
            <li class="nav-item"><a href="./register.php" class="nav-link">Register</a></li>
            <li class="nav-item"><a href="./reports.php" class="nav-link">Reports</a></li>
        </ul>
        <div class="accounts-cont"></div>
    </nav>
    <div class="dashboard-cont">
        <div class="dash-bkg">
            <img src="./img/dash-bkg.png" alt="" class="dash-bkg-img">
            <div class="bkg-overlay"></div>
        </div>
        <h1>Dashboard</h1>
        <div class="navigation-panels">
            <div class="panel-cont">
                <img src="./img/search.svg" alt="search-svg">
                <h2>Search</h2>
                <p>Search for existing Thesis titles available in the database</p>
                <button class="panel-btn">Search</button>
            </div>
            <div class="panel-cont">
                <img src="./img/forms.svg" alt="search-svg">
                <h2>Register</h2>
                <p>Register your ongoing Thesis Project to the University Database</p>
                <button class="panel-btn" onclick="window.location.href = './register.php';">Register</button>
            </div>
            <div class="panel-cont">
                <img src="./img/reports.svg" alt="search-svg">
                <h2>Reports</h2>
                <p>View and analyze the public Thesis reports</p>
                <button class="panel-btn" onclick="window.location.href = './reports.php';">Reports</button>
            </div>
        </div>
    </div>
</body>

</html>