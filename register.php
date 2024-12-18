<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/Navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <title>DB Registration Form</title>
</head>
<?php
require __DIR__ . '/utils/registration.php';
require __DIR__ . '/utils/data.php';
?>

<body>
    <nav>
        <div class="logo-cont">
            <img src="./img/dlsud-logo.png" alt="dlsud-logo">
            <h2>University Thesis Inventory</h2>
        </div>
        <ul class="nav-list">
            <li class="nav-item"><a href="./index.php" class="nav-link">Dashboard</a></li>
            <li class="nav-item active">Register</li>
            <li class="nav-item"><a href="./login.php" class="nav-link">Admin</a></li>
        </ul>
        <div class="accounts-cont"></div>
    </nav>
    <div class="registration-container">
        <div class="forms-container">
            <div class="form-header">
                <div class="logo-container">
                    <img src="img/dlsud-logo.png" class="dlsud-logo-img" />
                </div>
                <div class="header-content">
                    <h1>De La Salle University</h1>
                    <h2>DASMARINAS</h2>
                </div>
            </div>
            <form id="registration-form" target="_top" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="slider">
                    <!-- Thesis Basic Info -->
                    <div class="category-container">
                        <div class="category-header">
                            <h2>Identification</h2>
                            <p>Please fill out the necessary details to add the thesis item into the database</p>
                        </div>
                        <div class="field-container">
                            <label for="thesis-title">Title </label>
                            <input class="full" type="text" id="thesis-title" name="thesis-title">
                        </div>

                        <div class="field-container flex">
                            <div>
                                <label for="school-year">School Year</label>
                                <input required placeholder="202X-2XXX" class="full" type="text" name="school-year"
                                    id="school-year" pattern="[0-9]{4}-[0-9]{4}">
                            </div>
                            <div>
                                <label for="date-of-submission">Date of Submission</label>
                                <input required class="full" type="date" name="date-of-submission"
                                    id="date-of-submission" min="1900-01-01"><br>
                            </div>
                        </div>
                        <?php

                        if (isset($_POST['submit'])) {
                            $conn = connectDb();

                            $title = $_POST['thesis-title'];
                            $thesi = checkTitle($conn, $title);
                            if (empty($_POST['thesis-title'])) {
                                echo "<div class=\"error-msg\">
                                        <h5>NO THESIS TITLE</h5>
                                        <p>There is no thesis title entered.</p>
                                    </div>";
                            } else if (count($thesi) > 0) {
                                echo "<div class=\"error-msg\">
                                        <h5>IDENTICAL THESIS TITLE</h5>
                                        <p>There is a similar thesis title, <b>$title</b>, saved within the database. Please change your title acccordingly.</p>
                                    </div>";
                            } else if (!isCoAdviserValid()) {
                                echo "<div class=\"error-msg\">
                                        <h5>INCOMPLETE THESIS CO-ADVISER NAME</h5>
                                        <p>Please enter the full name of your thesis co-adviser or leave it empty otherwise.</p>
                                    </div>";
                            } else if (checkAuthors()) {
                                echo "<div class=\"error-msg\">
                                        <h5>IDENTICAL AUTHORS</h5>
                                        <p>There are similar authors upon registering the thesis. Please Fill up the Registration form again with different authors.</p>
                                    </div>";
                            } else {
                                insertToDb($conn);
                            }
                        }

                        ?>
                        <div class="form-control-container">
                            <button class="reset" onclick="window.location.reload()">Reset</button>
                            <button type="button" class="form-control affirm next"
                                onclick="nextHandler(event)">Next</button>
                        </div>
                    </div>

                    <!-- Authors -->
                    <div class="category-container">
                        <div class="category-header">
                            <h2>Authors</h2>
                            <p>Enter the owners/authors of the thesis</p>
                        </div>
                        <div class="authors-control">
                            <button type="button" onclick="addAuthor()">Add</button>
                        </div>
                        <div id="authors-fieldset-container" class="author-fields-container">
                            <div class="field-container">
                                <label for="author-1">Author 1</label>
                                <div class="flex">
                                    <input class="full" type="text" name="author-1-last" id="author-1-last"
                                        placeholder="Last Name" required>
                                    <input class="full" type="text" name="author-1-first" id="author-1-first"
                                        placeholder="First Name" required>
                                    <input class="full" type="text" name="author-1-middle" id="author-1-middle"
                                        placeholder="Middle Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-control-container">
                            <button type="button" class="form-control" onclick="prevHandler()">Prev</button>
                            <button type="button" onclick="nextHandler(event)"
                                class="form-control affirm next">Next</button>
                        </div>
                    </div>

                    <!-- Advisers -->
                    <div class="category-container">
                        <div class="category-header">
                            <h2>Advisers</h2>
                            <p>Enter the advisers, and Co-Advisers if applicable, for the given thesis</p>
                        </div>

                        <div class="field-container">
                            <label for="adviser">Adviser</label>
                            <div class="flex">
                                <input class="full" type="text" id="adviser-last" name="adviser-last"
                                    placeholder="Last Name" required>
                                <input class="full" type="text" id="adviser-first" name="adviser-first"
                                    placeholder="First Name" required>
                                <input class="full" type="text" id="adviser-middle" name="adviser-middle"
                                    placeholder="Middle Name" required>
                            </div>
                        </div>
                        <div class="field-container">
                            <label for="co-adviser">Co-Adviser</label>
                            <div class="flex">
                                <input class="full" type="text" id="co-adviser-last" name="co-adviser-last"
                                    placeholder="Last Name">
                                <input class="full" type="text" id="co-adviser-first" name="co-adviser-first"
                                    placeholder="First Name">
                                <input class="full" type="text" id="co-adviser-middle" name="co-adviser-middle"
                                    placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="form-control-container">
                            <button type="button" class="form-control" onclick="prevHandler()">Prev</button>
                            <button type="button" onclick="nextHandler(event)"
                                class="form-control affirm next">Next</button>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="category-container">
                        <div class="category-header">
                            <h2>Contact Information</h2>
                            <p>
                                Please enter the contact information of your contact person
                                to answer any additional inquiries in the future
                            </p>
                        </div>
                        <div class="field-container">
                            <label for="contact-email">Email: </label>
                            <input required placeholder="email@mail.com" type="email" name="contact-email"
                                id="contact-email"><br>
                        </div>
                        <div class="field-container">
                            <label for="contact-number">Contact Number: </label>
                            <input required placeholder="9XXXXXXXXX" type="tel" name="contact-number"
                                id="contact-number">
                        </div>
                        <div class="form-control-container">
                            <button type="button" class="form-control" onclick="prevHandler()">Prev</button>
                            <button type="button" onclick="nextHandler(event)"
                                class="form-control affirm next">Next</button>
                        </div>
                    </div>

                    <!-- Program Information -->
                    <div class="category-container">
                        <div class="category-header">
                            <h2>Program Information</h2>
                            <p>Enter the program information of the given thesis</p>
                        </div>
                        <div class="field-container">
                            <label for="program">Program</label>
                            <select name="program" id="program">
                                <option value disabled selected>---</option>
                                <?php
                                foreach ($PROGRAMS as $code => $program) {
                                    echo "<option value=\"$code\">$program</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field-container">
                            <label for="co-program">Co-Program</label>
                            <select name="co-program" id="co-program">
                                <option value selected>---</option>
                                <?php
                                foreach ($PROGRAMS as $code => $program) {
                                    echo "<option value=\"$code\">$program</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="field-container">
                            <label for="subject-study">Subject of Study</label>
                            <select name="subject-study" id="subject-study">
                                <option value selected>---</option>
                                <?php
                                foreach ($SUBJECTS as $subject) {
                                    echo "<option value=\"$subject\">$subject</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-control-container">
                            <button type="button" class="form-control" onclick="prevHandler()">Prev</button>
                            <input type="submit" class="form-control affirm" value="SUBMIT" name="submit">
                        </div>
                    </div>


                </div>
                <div class="progress-cont">
                    1/3
                </div>
            </form>
        </div>
        <div class="img-container">
            <img src="img/form-background.jpg" alt="form-background">
        </div>
    </div>

    <script src="./script.js"></script>
</body>

</html>