<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="stylesheet" href="css/Reports.css">
    <title>Reports</title>
</head>

<?php
require __DIR__ . '/utils/data.php';
require __DIR__ . '/utils/report_utils.php';

$serverName = "NeurosLaptop\SQLEXPRESS";

$connectionOptions = [
    "Database" => "WEBAPP",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);
$filter_type = 'all';
if (isset($_POST['filter-type'])) $filter_type = $_POST['filter-type'];
$filter_value = null;


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'FILTER' && $filter_type != 'all') {
        if ($filter_type != null) {
            $filter_value = getFilterValue($filter_type, $_POST);
        }
    }
}

$filter_data = filter_query($conn, $filter_type, $filter_value);
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

    <form class="reports-query-cont" id="filter-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="filter-select-cont">
            <select name="filter-type" id="filter-type-select" onchange="onFilterSelectChange(event)">
                <?php
                $filter_types = ['all', 'title', 'program', 'author', 'adviser'];

                foreach ($filter_types as $type) {
                    $formatted_type = ucfirst($type);
                    if ($filter_type == $type) echo "<option selected value=\"$type\">{$formatted_type}</option>";
                    else echo "<option value=\"$type\">{$formatted_type}</option>";
                }
                ?>
            </select>
        </div>
        <div style="display: <?php echo $filter_type == 'title' ? 'block' : 'none'; ?>;">
            <label for="title">Title: </label>
            <input value="<?php echo htmlspecialchars($filter_value ? $filter_value[$filter_type] : ''); ?>" name="title" id="" class="title-input"></input>
        </div>
        <div style="display: <?php echo $filter_type == 'author' ? 'block' : 'none'; ?>;">
            <label for="author">Author:</label>
            <div>
                <input value="<?php if (isset($filter_value['FIRST_NAME'])) echo $filter_value['FIRST_NAME']; ?>" type="text" name="author-fn" placeholder="First Name">
                <input value="<?php if (isset($filter_value['LAST_NAME'])) echo $filter_value['LAST_NAME']; ?>" type="text" name="author-ln" placeholder="Last Name">
            </div>
        </div>
        <div style="display: <?php echo $filter_type == 'adviser' ? 'block' : 'none'; ?>;">
            <label for="author">Adviser:</label>
            <div>
                <input value="<?php if (isset($filter_value['FIRST_NAME'])) echo $filter_value['FIRST_NAME']; ?>" type="text" name="adviser-fn" placeholder="First Name">
                <input value="<?php if (isset($filter_value['LAST_NAME'])) echo $filter_value['LAST_NAME']; ?>" type="text" name="adviser-ln" placeholder="Last Name">
            </div>
        </div>
        <div style="display: <?php echo $filter_type == 'program' ? 'block' : 'none'; ?>;">
            <label for="program">Program:</label>
            <select name="program">
                <option value <?php echo is_null($filter_value) ? '' : 'selected' ?>>Select Program</option>
                <?php
                $filter_value = $filter_value[$filter_type];
                foreach ($PROGRAMS as $key => $program) {
                    if ($filter_value == $key) echo "<option selected value=\"$key\">$program</option>";
                    else echo "<option value=\"$key\">$program</option>";
                }
                ?>
            </select>
        </div>
        <div style="display: <?php echo $filter_type != 'all' ? 'block' : 'none'; ?>;" class="form-actions">
            <input type="submit" value="FILTER" name="action" class="filter-btn">
            <input type="submit" value="RESET" name="action" class="cancel-btn">
        </div>
    </form>

    <!-- ========================== ALL TABLE ========================== -->
    <div class="reports-cont">
        <div class="table-cont">
            <div class="header-container">
                <div class="header-info">
                    <div class="table-header">
                        <h3><?php echo ucwords($filter_type); ?></h3>
                        <?php
                        $filter_count = count($filter_data);
                        echo "<div class=\"count-cont\">{$filter_count} Total</div>";
                        ?>
                    </div>
                    <p>Displays all the Thesis entries with the first author</p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <?php
                        if ($filter_type) {
                            foreach (getFilterColumns($filter_type) as $filter_key => $filter_column) {
                                echo "<th>$filter_column</th>";
                            }
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($filter_data as $row) {
                        echo "<tr class=\"table-row\">";
                        foreach (getFilterColumns($filter_type) as $filter_key => $filter_column) {
                            if ($filter_key == 'TITLE_NAME') echo "<td class=\"td-title-name\">{$row[$filter_key]}</td>";
                            else echo "<td>{$row[$filter_key]}</td>";
                        }
                        echo "</tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>

    <script>
        function onFilterSelectChange(e) {
            let filterFormEl = document.getElementById('filter-form');
            filterFormEl.submit();
        }
    </script>
</body>

</html>