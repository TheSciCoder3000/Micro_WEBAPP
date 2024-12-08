<?php


function getFilterValue(String $filter_type, array $data)
{
    if ($filter_type == 'author') {
        return [
            'LAST_NAME' => $data['author-ln'],
            'FIRST_NAME' => $data['author-fn'],
        ];
    } else if ($filter_type == 'adviser') {
        return [
            'LAST_NAME' => $data['adviser-ln'],
            'FIRST_NAME' => $data['adviser-fn'],
        ];
    } else return [
        $filter_type => $data[$filter_type]
    ];
}

function filter_query($conn, string $filter_type, array|null $filter_value)
{
    $filter_sql = "";
    if ($filter_type == 'all') {
        $filter_sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME 
        FROM TITLE AS t 
            INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID 
            INNER JOIN (
                SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID 
                FROM AUTHOR GROUP BY TITLE_ID
            ) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID;";
    } else if ($filter_type == 'title') {
        $filter_value = isset($filter_value[$filter_type]) ? $filter_value[$filter_type] : null;
        $filter_sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME 
        FROM TITLE AS t 
            INNER JOIN AUTHOR AS a ON t.TITLE_ID = a.TITLE_ID 
            INNER JOIN (
                SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID 
                FROM AUTHOR GROUP BY TITLE_ID
            ) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID
        WHERE t.TITLE_NAME LIKE '%$filter_value%';";
    } else if ($filter_type == 'program') {
        $filter_value = isset($filter_value[$filter_type]) ? $filter_value[$filter_type] : null;
        $filter_value = $filter_value == '' || $filter_value == null ? '%%' : $filter_value;
        $filter_sql = "SELECT t.TITLE_ID, t.TITLE_NAME, t.PROGRAM, a.LAST_NAME, a.FIRST_NAME 
            FROM TITLE AS t 
                INNER JOIN AUTHOR AS a 
                ON t.TITLE_ID = a.TITLE_ID 
                INNER JOIN (
                    SELECT TITLE_ID, MIN(AUTHOR_ID) AS FIRST_ID 
                    FROM AUTHOR GROUP BY TITLE_ID
                ) AS FA ON a.TITLE_ID = FA.TITLE_ID AND a.AUTHOR_ID = FA.FIRST_ID
            WHERE PROGRAM LIKE '$filter_value';";
    } else if ($filter_type == 'author') {
        $ln_filter_value = $filter_value == null || !isset($filter_value['LAST_NAME']) ? '' : $filter_value['LAST_NAME'];
        $fn_filter_value = $filter_value == null || !isset($filter_value['FIRST_NAME']) ? '' : $filter_value['FIRST_NAME'];

        $filter_sql = "SELECT A.FIRST_NAME, A.LAST_NAME, T.TITLE_ID, T.TITLE_NAME 
            FROM AUTHOR AS A
                INNER JOIN TITLE AS T
                ON T.TITLE_ID = A.TITLE_ID
            WHERE A.LAST_NAME LIKE '%$ln_filter_value%' AND A.FIRST_NAME LIKE '%$fn_filter_value%';";
    } else if ($filter_type == 'adviser') {
        $ln_filter_value = $filter_value == null || !isset($filter_value['LAST_NAME']) ? '' : $filter_value['LAST_NAME'];
        $fn_filter_value = $filter_value == null || !isset($filter_value['FIRST_NAME']) ? '' : $filter_value['FIRST_NAME'];

        $filter_sql = "SELECT A.FIRST_NAME, A.LAST_NAME, T.TITLE_ID, T.TITLE_NAME 
            FROM ADVISER AS A
                INNER JOIN TITLE AS T
                ON T.TITLE_ID = A.TITLE_ID
            WHERE A.LAST_NAME LIKE '%$ln_filter_value%' AND A.FIRST_NAME LIKE '%$fn_filter_value%';";
    }

    if ($filter_sql == "") return null;

    $filter_res = sqlsrv_query($conn, $filter_sql);
    $filter_data = [];
    while ($row = sqlsrv_fetch_array($filter_res)) {
        $filter_data[] = $row;
    }

    return $filter_data;
}

function getFilterColumns(String $filter_type)
{
    if ($filter_type == 'title') return [
        'TITLE_ID' => 'Title ID',
        'TITLE_NAME' => 'Title Name',
        'PROGRAM' => 'Program',
        'LAST_NAME' => 'Author Last Name',
        'FIRST_NAME' => 'Author First Name',
    ];

    if ($filter_type == 'all') return [
        'TITLE_ID' => 'Title ID',
        'TITLE_NAME' => 'Title Name',
        'PROGRAM' => 'Program',
        'LAST_NAME' => 'Author Last Name',
        'FIRST_NAME' => 'Author First Name',
    ];

    if ($filter_type == 'program') return [
        'PROGRAM' => 'Program',
        'TITLE_ID' => 'Title ID',
        'TITLE_NAME' => 'Title Name',
        'LAST_NAME' => 'Author Last Name',
        'FIRST_NAME' => 'Author First Name',
    ];

    if ($filter_type == 'author') return [
        'FIRST_NAME' => 'Author First Name',
        'LAST_NAME' => 'Author Last Name',
        'TITLE_ID' => 'Title ID',
        'TITLE_NAME' => 'Title Name',
    ];

    if ($filter_type == 'adviser') return [
        'FIRST_NAME' => 'Adviser First Name',
        'LAST_NAME' => 'Adviser Last Name',
        'TITLE_ID' => 'Title ID',
        'TITLE_NAME' => 'Title Name',
    ];
}
