<?php

function getSearchData(String $searchKey)
{
    $search_key = trim($searchKey);

    $serverName = "NeurosLaptop\SQLEXPRESS";

    $connectionOptions = [
        "Database" => "WEBAPP",
        "Uid" => "",
        "PWD" => ""
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);

    $sql = null;

    if ($search_key == "ALL") {
        $sql = "SELECT T.TITLE_ID, T.TITLE_NAME, T.PROGRAM, a.LAST_NAME, a.FIRST_NAME, PA.PDF_PATH FROM TITLE AS T
            INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID 
            INNER JOIN (
                SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID 
                FROM AUTHOR GROUP BY TITLE_ID
            ) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID
            INNER JOIN ADVISER AS AD
            ON AD.TITLE_ID = T.TITLE_ID
            INNER JOIN CO_ADVISER AS CO
            ON CO.TITLE_ID = T.TITLE_ID
            LEFT OUTER JOIN PDF_ABSTRACT AS PA
            ON PA.TITLE_ID = T.TITLE_ID
            ";
    } else {
        $sql = "SELECT T.TITLE_ID, T.TITLE_NAME, T.PROGRAM, a.LAST_NAME, a.FIRST_NAME, PA.PDF_PATH FROM TITLE AS T
            INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID 
            INNER JOIN (
                SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID 
                FROM AUTHOR GROUP BY TITLE_ID
            ) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID
            INNER JOIN ADVISER AS AD
            ON AD.TITLE_ID = T.TITLE_ID
            INNER JOIN CO_ADVISER AS CO
            ON CO.TITLE_ID = T.TITLE_ID
            LEFT OUTER JOIN PDF_ABSTRACT AS PA
            ON PA.TITLE_ID = T.TITLE_ID

            WHERE T.TITLE_NAME LIKE '%$search_key%' OR a.LAST_NAME LIKE '%$search_key%' OR a.FIRST_NAME LIKE '%$search_key%' OR T.PROGRAM LIKE '%$search_key%'
            ";
    }

    $res = sqlsrv_query($conn, $sql);
    $search_results = [];
    while ($row = sqlsrv_fetch_array($res)) {
        $search_results[] = $row;
    }

    return $search_results;
}

function getTableBody(array $search_results)
{

    foreach ($search_results as $res) {
        echo "<tr class=\"table-row\">";
        print_r("<td>" . $res['TITLE_ID'] . "</td>");
        print_r("<td class=\"td-title-name\">" . $res['TITLE_NAME'] . "</td>");
        print_r("<td>" . $res['PROGRAM'] . "</td>");
        print_r("<td>" . $res['LAST_NAME'] . "</td>");
        print_r("<td>" . $res['FIRST_NAME'] . "</td>");
        if ($res['PDF_PATH'] != null) print_r("<td>
                <form action=\"viewfile.php\" method=\"post\">
                    <input type=\"hidden\" name=\"file-path\" value=\"" . $res['PDF_PATH'] . "\">
                    <input type=\"submit\" value=\"View\">
                </form>
            </td>");
        else print_r("<td></td>");
        echo "</tr>";
    }
}
