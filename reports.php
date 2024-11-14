<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Reports.css">
    <title>Reports</title>
</head>

<?php
$serverName = "NeurosLaptop\SQLEXPRESS";

$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

?>

<body>
    <nav>
        <div class="logo-cont"></div>
        <div class="nav-list">
            <div class="nav-item"><a href="./index.php" class="nav-link">Dashboard</a></div>
            <div class="nav-item"><a href="./register.php" class="nav-link">Register</a></div>
            <div class="nav-item active">Reports</div>
        </div>
        <div class="accounts-cont"></div>
    </nav>

    <!-- ========================== ALL TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="table-header">
                    <h3>ALL</h3>
                    <?php
                    $all_count_sql = "SELECT COUNT(TITLE_ID) as ALL_COUNT FROM TITLE";
                    $all_count_query = sqlsrv_query($conn, $all_count_sql);
                    $all_count_result = sqlsrv_fetch_array($all_count_query);
                    echo "<div class=\"count-cont\">{$all_count_result['ALL_COUNT']} Total</div>";
                    ?>
                </div>
                <p>Displays all the Thesis entries with the first author</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Title ID</th>
                        <th>Title Name</th>
                        <th>Program</th>
                        <th>Author Last Name</th>
                        <th>Author First Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME FROM TITLE AS t INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID INNER JOIN (SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID FROM AUTHOR GROUP BY TITLE_ID) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID;";
                    $title_results = sqlsrv_query($conn, $sql);
                    $count = 0;
                    while ($row = sqlsrv_fetch_array($title_results)) {
                        $count = $count + 1;
                        $title_name = $row['TITLE_NAME'];
                        echo "<tr class=\"table-row\">
                                <td>{$row['TITLE_ID']}</td>
                                <td class=\"td-title-name\">{$row['TITLE_NAME']}</td>
                                <td>{$row['PROGRAM']}</td>
                                <td>{$row['LAST_NAME']}</td>
                                <td>{$row['FIRST_NAME']}</td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================== ALL TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="table-header">
                    <h3>TITLE</h3>
                    <?php
                    $all_count_sql = "SELECT COUNT(TITLE_ID) as ALL_COUNT FROM TITLE";
                    $all_count_query = sqlsrv_query($conn, $all_count_sql);
                    $all_count_result = sqlsrv_fetch_array($all_count_query);
                    echo "<div class=\"count-cont\">{$all_count_result['ALL_COUNT']} Total</div>";
                    ?>
                </div>
                <p>Displays all the Thesis entries with the first author</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Title ID</th>
                        <th>Title Name</th>
                        <th>Program</th>
                        <th>Author Last Name</th>
                        <th>Author First Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME FROM TITLE AS t INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID INNER JOIN (SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID FROM AUTHOR GROUP BY TITLE_ID) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID;";
                    $title_results = sqlsrv_query($conn, $sql);
                    $count = 0;
                    while ($row = sqlsrv_fetch_array($title_results)) {
                        $count = $count + 1;
                        $title_name = $row['TITLE_NAME'];
                        echo "<tr class=\"table-row\">
                                <td>{$row['TITLE_ID']}</td>
                                <td class=\"td-title-name\">{$row['TITLE_NAME']}</td>
                                <td>{$row['PROGRAM']}</td>
                                <td>{$row['LAST_NAME']}</td>
                                <td>{$row['FIRST_NAME']}</td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================== PROGRAM TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="table-header">
                    <h3>PROGRAM</h3>
                    <?php
                    $program_count_sql = "SELECT COUNT(TITLE_ID) as ALL_COUNT FROM TITLE";
                    $program_count_query = sqlsrv_query($conn, $program_count_sql);
                    $program_count_result = sqlsrv_fetch_array($program_count_query);
                    echo "<div class=\"count-cont\">{$program_count_result['ALL_COUNT']} Total</div>";
                    ?>
                </div>
                <p>Displays all the thesis titles and its program code</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Program</th>
                        <th>Title ID</th>
                        <th>Title Name</th>
                        <th>Author Last Name</th>
                        <th>Author First Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME FROM TITLE AS t INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID INNER JOIN (SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID FROM AUTHOR GROUP BY TITLE_ID) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID;";
                    $title_results = sqlsrv_query($conn, $sql);
                    $count = 0;
                    while ($row = sqlsrv_fetch_array($title_results)) {
                        $count = $count + 1;
                        $title_name = $row['TITLE_NAME'];
                        echo "<tr class=\"table-row\">
                                <td>{$row['PROGRAM']}</td>
                                <td>{$row['TITLE_ID']}</td>
                                <td class=\"td-title-name\">{$row['TITLE_NAME']}</td>
                                <td>{$row['LAST_NAME']}</td>
                                <td>{$row['FIRST_NAME']}</td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================== AUTHOR TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="table-header">
                    <h3>AUTHORS</h3>
                    <?php
                    $author_count_sql = "SELECT COUNT(TITLE_ID) as ALL_COUNT FROM AUTHOR";
                    $author_count_query = sqlsrv_query($conn, $author_count_sql);
                    $author_count_result = sqlsrv_fetch_array($author_count_query);
                    echo "<div class=\"count-cont\">{$author_count_result['ALL_COUNT']} Total</div>";
                    ?>
                </div>
                <p>Displays all the authors and their thesis</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Title ID</th>
                        <th>Title Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $author_sql = "SELECT A.FIRST_NAME, A.LAST_NAME, T.TITLE_ID, T.TITLE_NAME 
                            FROM AUTHOR AS A
                            INNER JOIN TITLE AS T
                            ON T.TITLE_ID = A.TITLE_ID;";
                    $author_query = sqlsrv_query($conn, $author_sql);
                    while ($row = sqlsrv_fetch_array($author_query)) {
                        echo "<tr class=\"table-row\">
                                <td>{$row['FIRST_NAME']}</td>
                                <td>{$row['LAST_NAME']}</td>
                                <td>{$row['TITLE_ID']}</td>
                                <td class=\"td-title-name\">{$row['TITLE_NAME']}</td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================== ADVISER TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="table-header">
                    <h3>ADVISERS</h3>
                    <?php
                    $adviser_count_sql = "SELECT COUNT(TITLE_ID) as ALL_COUNT FROM ADVISER";
                    $adviser_count_query = sqlsrv_query($conn, $adviser_count_sql);
                    $adviser_count_result = sqlsrv_fetch_array($adviser_count_query);
                    echo "<div class=\"count-cont\">{$adviser_count_result['ALL_COUNT']} Total</div>";
                    ?>
                </div>
                <p>Displays all the advisers and their thesis</p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Title ID</th>
                        <th>Title Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $author_sql = "SELECT A.FIRST_NAME, A.LAST_NAME, T.TITLE_ID, T.TITLE_NAME 
                            FROM ADVISER AS A
                            INNER JOIN TITLE AS T
                            ON T.TITLE_ID = A.TITLE_ID;";
                    $author_query = sqlsrv_query($conn, $author_sql);
                    while ($row = sqlsrv_fetch_array($author_query)) {
                        echo "<tr class=\"table-row\">
                                <td>{$row['FIRST_NAME']}</td>
                                <td>{$row['LAST_NAME']}</td>
                                <td>{$row['TITLE_ID']}</td>
                                <td class=\"td-title-name\">{$row['TITLE_NAME']}</td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>