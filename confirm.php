<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Confirm.css">

    <title>Confirmation Page</title>
</head>
<?php
require __DIR__ . '/utils/registration.php';

$conn = connectDb();
$sql = "SELECT * FROM TITLE WHERE TITLE_ID = (SELECT IDENT_CURRENT('TITLE'));";
$results = sqlsrv_query($conn, $sql);
$thesis = sqlsrv_fetch_array($results);

$thesisId = $thesis['TITLE_ID'];

$authorsSql = "SELECT * FROM AUTHOR WHERE TITLE_ID = $thesisId;";
$authorResults = sqlsrv_query($conn, $authorsSql);
$authors = [];
while ($row = sqlsrv_fetch_array($authorResults)) {
    $authors[] = $row;
}

$adviserSql = "SELECT * FROM ADVISER WHERE TITLE_ID = $thesisId;";
$adviserResults = sqlsrv_query($conn, $adviserSql);
$adviser = sqlsrv_fetch_array($adviserResults);

$coAdviserSql = "SELECT * FROM CO_ADVISER WHERE TITLE_ID = $thesisId;";
$coAdviserResults = sqlsrv_query($conn, $coAdviserSql);
$coAdviser = sqlsrv_fetch_array($coAdviserResults);

$contactSql = "SELECT * FROM CONTACT WHERE TITLE_ID = $thesisId;";
$contactResults = sqlsrv_query($conn, $contactSql);
$contact = sqlsrv_fetch_array($contactResults);

?>

<body>
    <div class="img-container">
        <img src="./img/checklist.svg" alt="">
    </div>
    <div class="research-summary">
        <h1>Application Summary</h1>
        <p>Please verify your registration details and contact your adviser for any issues</p>
        <div class="info-cont basic-info-container">
            <h2>Basic Information</h2>
            <p>
                <b>ID: </b>
                <?php echo $thesis['TITLE_ID'] ?>
            </p>
            <p>
                <b>Name: </b>
                <?php echo $thesis['TITLE_NAME'] ?>
            </p>
            <p>
                <b>School Year: </b>
                <?php echo $thesis['SCHOOL_YEAR'] ?>
            </p>
            <p>
                <b>Date of Submission: </b>
                <?php echo $thesis['DATE_OF_SUBMISSION']->format('M d, Y') ?>
            </p>
        </div>
        <div class="info-cont authors-container">
            <h2>Authors</h2>
            <?php

            foreach ($authors as $author) {
                $last = $author['LAST_NAME'];
                $first = $author['FIRST_NAME'];
                $middle = $author['MIDDLE_NAME'];
                echo "<p class=\"author-p\">$last, $first $middle</p>";
            }

            ?>
        </div>
        <div class="info-cont advisers-container">
            <h2>Advisers</h2>
            <p>
                <b>Adviser: </b>
                <?php echo "{$adviser['LAST_NAME']}, {$adviser['FIRST_NAME']} {$adviser['MIDDLE_NAME']}" ?>
            </p>
            <?php
            if (!empty($coAdviser['LAST_NAME'])) {
                echo "<p>
                        <b>Co-Adviser: </b>
                        {$coAdviser['LAST_NAME']}, {$coAdviser['FIRST_NAME']} {$coAdviser['MIDDLE_NAME']}
                    </p>";
            }
            ?>
        </div>
        <div class="info-cont contact-container">
            <h2>Contact Information: </h2>
            <p>
                <b>Phone No: </b>
                <?php echo $contact['PHONE_NUMBER']; ?>
            </p>
            <p>
                <b>Email: </b>
                <?php echo $contact['EMAIL']; ?>
            </p>
        </div>
        <div class="info-cont subject-info-container">
            <h2>Subject Information: </h2>
            <p>
                <b>Program: </b>
                <?php echo $thesis['PROGRAM']; ?>
            </p>
            <p>
                <b>Co-Program: </b>
                <?php echo $thesis['CO_PROGRAM']; ?>
            </p>
            <p>
                <b>Subject of Study: </b>
                <?php echo $thesis['SUBJECT']; ?>
            </p>
        </div>
    </div>
    <div class="success-actions">
        <button class="edit-btn" onclick="redirectEdit()">EDIT</button>
        <button class="save-btn" onclick="redirectSave()">SAVE</button>
    </div>
    <script>
        function redirect() {
            window.location.href = "http://localhost/webapp/register";
        }

        function redirectEdit() {
            window.location.href = "http://localhost/webapp/edit.php";
        }

        function redirectSave() {
            window.location.href = "http://localhost/webapp/success.php";
        }
    </script>
</body>

</html>