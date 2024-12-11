<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Search.css">
    <title>Search for Thesis</title>
</head>

<body>
    <nav>
        <div class="logo-cont">
            <img src="./img/dlsud-logo.png" alt="dlsud-logo">
            <h2>University Thesis Inventory</h2>
        </div>
        <ul class="nav-list">
            <li class="nav-item"><a href="./index.php" class="nav-link">Dashboard</a></li>
            <li class="nav-item"><a href="./register.php" class="nav-link">Register</a></li>
            <li class="nav-item"><a href="./admin.php" class="nav-link">Admin</a></li>
        </ul>
        <div class="accounts-cont"></div>
    </nav>
    <div class="search-cont">
        <div class="hero-search-cont">
            <img class="negative-img" src="./img/negative-bkg.png" alt="">
            <img class="main-img" src="./img/library-bkg.png" alt="">
        </div>
        <div class="main-search-cont">
            <div class="search-bar-cont">
                <h1>University Thesis Inventory</h1>
                <div class="search-bar">
                    <form id="search-bar-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input value="<?php if (isset($_POST['search-key'])) echo htmlspecialchars($_POST['search-key'] != 'ALL' ? $_POST['search-key'] : ''); ?>" type="text" name="search-key" placeholder="Search Thesis Here..." class="search-input" autocomplete="off" required>
                    </form>
                    <form id="search-all-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="submit" value="ALL" name="search-key">
                    </form>
                </div>
            </div>
        </div>





        <?php

        require __DIR__ . '/utils/data.php';
        require __DIR__ . '/utils/search_util.php';

        if (isset($_POST['search-key']) && is_value_empty($_POST['search-key'])) {
            $search_value = $_POST['search-key'];
            $search_results = getSearchData($search_value);

            echo "<div class=\"search-results-cont\"><table>";

            echo "<thead>
                        <tr>
                            <th>THESIS ID</th>
                            <th>TITLE NAME</th>
                            <th>PROGRAM</th>
                            <th>LAST NAME</th>
                            <th>FIRST NAME</th>
                            <th></th>
                        </tr>
                    </thead>";

            echo "<tbody>";
            getTableBody($search_results);
            echo "</tbody>";

            echo "</table></div>";
        }

        ?>

    </div>
</body>

</html>