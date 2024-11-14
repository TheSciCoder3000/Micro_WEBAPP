<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>TITLE ID</th>
                <th>TITLE NAME</th>
                <th>Program</th>
                <th>Author Last Name</th>
                <th>Author First Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $serverName = "NeurosLaptop\SQLEXPRESS";

            $connectionOptions = [
                "Database" => "WEBAPP",
                "Uid" => "",
                "PWD" => ""
            ];

            $conn = sqlsrv_connect($serverName, $connectionOptions);

            $sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME FROM TITLE AS t INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID INNER JOIN (SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID FROM AUTHOR GROUP BY TITLE_ID) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID;";
            $title_results = sqlsrv_query($conn, $sql);
            $count = 0;
            while ($row = sqlsrv_fetch_array($title_results)) {
                $count = $count + 1;
                $title_name = $row['TITLE_NAME'];
                echo "<tr>
                        <td>{$row['TITLE_ID']}</td>
                        <td>{$row['TITLE_NAME']}</td>
                        <td>{$row['PROGRAM']}</td>
                        <td>{$row['LAST_NAME']}</td>
                        <td>{$row['FIRST_NAME']}</td>
                    </tr>";
            }
            ?>

        </tbody>
    </table>
    <div>
        <?php
        echo "Number of Results: $count";
        ?>
    </div>
</body>

</html>