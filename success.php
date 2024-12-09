<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Success.css">
    <link rel="stylesheet" href="./css/Navbar.css">
    <title>Registration Successful</title>
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

$pdfsql = "SELECT * FROM PDF_UPLOAD WHERE TITLE_ID = $thesisId;";
$pdfResult = sqlsrv_query($conn, $pdfsql);
$pdf = sqlsrv_fetch_array($pdfResult);

?>

<body>
    <nav>
        <div class="logo-cont"></div>
        <ul class="nav-list">
            <li class="nav-item"><a href="./index.php" class="nav-link">Dashboard</a></li>
            <li class="nav-item active">Register</li>
            <li class="nav-item"><a href="./admin.php" class="nav-link">Admin</a></li>
        </ul>
        <div class="accounts-cont"></div>
    </nav>
    <div class="alert-container">
        <div class="hero-content">
            <h1>Congratulations in <br>Registering your Thesis</h1>
            <p>
                You have successfully uploaded your thesis, <?php echo "<b>{$thesis['TITLE_NAME']}</b>" ?>
                , with a thesis id number of <?php echo "<b>{$thesis['TITLE_ID']}</b>" ?>. Feel free to ask your
                adviser for any inquiries or add a new entry by clicking
                the button below.
            </p>
            <?php
            if (!is_null($pdf)) {
                echo "<button class=\"register\" onclick=\"redirect()\">REGISTER</button>";
            } else {
                echo "<button class=\"register\" onclick=\"redirectUpload()\">Add Thesis PDF</button>";
            }
            ?>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="722.45196" height="364.19648" viewBox="0 0 722.45196 364.19648" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M891.45711,564.13287H342.14841a26.51638,26.51638,0,0,1-26.48658-26.48658V329.2084a26.51674,26.51674,0,0,1,26.48658-26.48658h549.3087a26.51674,26.51674,0,0,1,26.48658,26.48658V537.64629A26.51638,26.51638,0,0,1,891.45711,564.13287Z" transform="translate(-238.77402 -267.90176)" fill="#fff" />
            <path d="M891.45711,564.13287H342.14841a26.51638,26.51638,0,0,1-26.48658-26.48658V329.2084a26.51674,26.51674,0,0,1,26.48658-26.48658h549.3087a26.51674,26.51674,0,0,1,26.48658,26.48658V537.64629A26.51638,26.51638,0,0,1,891.45711,564.13287ZM342.14841,305.025a24.1834,24.1834,0,0,0-24.1834,24.1834V537.64629a24.1834,24.1834,0,0,0,24.1834,24.1834h549.3087a24.1834,24.1834,0,0,0,24.1834-24.1834V459.054A154.029,154.029,0,0,0,761.61156,305.025Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <ellipse cx="294.66589" cy="607.92128" rx="2.82511" ry="4.06109" transform="translate(-588.12138 544.08622) rotate(-81.72174)" fill="#fff" />
            <ellipse cx="321.09158" cy="605.34272" rx="2.8251" ry="4.06109" transform="translate(-562.94877 568.02927) rotate(-81.72174)" fill="#3f3d56" />
            <ellipse cx="287.42975" cy="586.52763" rx="2.82511" ry="4.06109" transform="translate(-573.14491 518.61211) rotate(-81.72174)" fill="#ff6584" />
            <ellipse cx="278.18048" cy="578.33571" rx="2.56661" ry="1.78547" transform="translate(-541.01619 584.23337) rotate(-89.56675)" fill="#e6e6e6" />
            <ellipse cx="274.28649" cy="562.01344" rx="2.56661" ry="1.78547" transform="translate(-528.55893 564.14064) rotate(-89.56675)" fill="#3f3d56" />
            <ellipse cx="304.56743" cy="590.7395" rx="2.56661" ry="1.78547" transform="translate(-527.2322 622.92957) rotate(-89.56675)" fill="#e6e6e6" />
            <ellipse cx="291.79739" cy="597.11543" rx="2.56661" ry="1.78547" transform="translate(-546.28142 616.48761) rotate(-89.56675)" fill="#ff6584" />
            <ellipse cx="309.57373" cy="608.89981" rx="2.56661" ry="1.78547" transform="translate(-540.42354 645.95872) rotate(-89.56675)" fill="#3f3d56" />
            <ellipse cx="932.08298" cy="274.37106" rx="3.60111" ry="5.1766" transform="translate(198.37253 842.58896) rotate(-75.77932)" fill="#fff" />
            <ellipse cx="898.23933" cy="274.15294" rx="3.60111" ry="5.1766" transform="translate(173.05426 809.61785) rotate(-75.77932)" fill="#3f3d56" />
            <ellipse cx="938.43394" cy="302.44956" rx="3.60111" ry="5.1766" transform="translate(175.94525 869.92612) rotate(-75.77932)" fill="#ff6584" />
            <ellipse cx="949.07942" cy="314.05614" rx="3.27161" ry="2.2759" transform="translate(292.79924 954.48891) rotate(-83.62433)" fill="#e6e6e6" />
            <ellipse cx="951.86235" cy="335.26393" rx="3.27161" ry="2.2759" transform="matrix(0.11105, -0.99382, 0.99382, 0.11105, 274.19651, 976.10735)" fill="#3f3d56" />
            <ellipse cx="917.26206" cy="294.84801" rx="3.27161" ry="2.2759" transform="translate(283.60443 905.79321) rotate(-83.62433)" fill="#e6e6e6" />
            <ellipse cx="934.29374" cy="288.44962" rx="3.27161" ry="2.2759" transform="translate(305.10362 917.03168) rotate(-83.62433)" fill="#ff6584" />
            <ellipse cx="913.31146" cy="271.16311" rx="3.27161" ry="2.2759" transform="translate(303.63095 880.81227) rotate(-83.62433)" fill="#3f3d56" />
            <path d="M535.37467,429.18554a84.29076,84.29076,0,0,1-21.6269,56.497v.01153a86.56041,86.56041,0,0,1-6.2416,6.26465,83.40511,83.40511,0,0,1-7.02468,5.70039q-2.5566,1.8655-5.25125,3.52387-3.19572,1.98642-6.5756,3.67357-2.50473,1.261-5.11307,2.34922a84.48558,84.48558,0,0,1-32.78575,6.59859,84.49842,84.49842,0,0,1-18.89764-2.11888,81.105,81.105,0,0,1-8.47569-2.41839c-1.071-.357-2.14194-.74849-3.20145-1.163a83.49857,83.49857,0,0,1-18.13755-9.731,84.61752,84.61752,0,1,1,133.33118-69.18758Z" transform="translate(-238.77402 -267.90176)" fill="#f2f2f2" />
            <path d="M788.63254,366.28377h-146.252a4.60637,4.60637,0,0,1,0-9.21273h146.252a4.60636,4.60636,0,0,1,0,9.21273Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M788.63254,428.46966h-146.252a4.60637,4.60637,0,0,1,0-9.21273h146.252a4.60637,4.60637,0,0,1,0,9.21273Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M788.63254,490.65555h-146.252a4.60637,4.60637,0,0,1,0-9.21273h146.252a4.60636,4.60636,0,0,1,0,9.21273Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M422.99456,628.07628c-16.51077-21.96123-26.0537-46.51942-26.36641-74.51777a6.04123,6.04123,0,0,1,3.676-7.70163l56.27746-19.91249a6.04122,6.04122,0,0,1,7.70161,3.676l26.3664,74.51777a6.04122,6.04122,0,0,1-3.67591,7.70163L430.6962,631.75223A6.04123,6.04123,0,0,1,422.99456,628.07628Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M419.34763,604.04139c-9.93022-10.04034-14.1809-27.94788-16.95072-47.90679a5.65767,5.65767,0,0,1,3.44264-7.21281l48.36574-17.11311a5.65791,5.65791,0,0,1,7.21308,3.44253l23.46251,66.31069a5.6579,5.6579,0,0,1-3.4429,7.2129L451.47641,619.376A25.202,25.202,0,0,1,419.34763,604.04139Z" transform="translate(-238.77402 -267.90176)" fill="#fff" />
            <path d="M462.06578,570.9731,424.3902,584.42138a2.40023,2.40023,0,1,1-1.6138-4.52107L460.452,566.452a2.40023,2.40023,0,1,1,1.6138,4.52107Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M428.25374,569.06581l-8.28863,2.95863a2.40023,2.40023,0,1,1-1.61379-4.52107l8.28863-2.95863a2.40023,2.40023,0,1,1,1.61379,4.52107Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M469.16044,590.8489l-37.67558,13.44829a2.40023,2.40023,0,0,1-1.61379-4.52107l37.67558-13.44829a2.40023,2.40023,0,0,1,1.61379,4.52107Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M465.61311,580.911l-37.67558,13.44829a2.40023,2.40023,0,0,1-1.6138-4.52107l37.67559-13.44829a2.40023,2.40023,0,1,1,1.61379,4.52107Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M431.40165,390.90232c1.22689,9.89882,8.086,18.06055,18.06055,18.06055a18.06055,18.06055,0,0,0,18.06055-18.06055c0-9.97457-8.12874-17.13836-18.06055-18.06055C438.92394,371.86326,429.82647,378.19347,431.40165,390.90232Z" transform="translate(-238.77402 -267.90176)" fill="#2f2e41" />
            <path d="M465.18522,512.57225a85.23361,85.23361,0,0,1-33.327-.88674C437.05187,508.81806,452.80562,510.58,465.18522,512.57225Z" transform="translate(-238.77402 -267.90176)" fill="#2f2e41" />
            <path d="M394.8913,544.33988l8.67549-20.96573,6.83522,3.79734-4.1279,21.32748a7.5956,7.5956,0,1,1-11.38281-4.15909Z" transform="translate(-238.77402 -267.90176)" fill="#ffb6b6" />
            <path d="M484.6356,487.60571v.01153c-.311,7.30111-.737,14.24517-1.094,19.58856a84.48558,84.48558,0,0,1-32.78575,6.59859,84.49842,84.49842,0,0,1-18.89764-2.11888,81.105,81.105,0,0,1-8.47569-2.41839,5.22916,5.22916,0,0,1,1.24374-.58725c4.1457-1.405.046-2.68322.08062-4.01911.12666-4.88273,1.474-10.74429,3.21291-16.36406L420.181,508.10408l-4.03057,10.29522s.13826,8.89024-2.41831,6.17251c-2.568-2.71774-2.3838,6.08036-2.3838,6.08036a8.01088,8.01088,0,0,0-2.02681,2.0959,1.77771,1.77771,0,0,0-.24179,1.23221v.01153a1.53922,1.53922,0,0,0,.64489.80613c1.73891,1.17457-.76009,4.28388-1.86558,5.51609-.29942.33394-.49517.52976-.49517.52976l-10.62923-.76009v-.20728c.04611-1.25519.334-7.86538,1.98077-9.44306,1.808-1.73884.92126-4.49116.92126-4.49116s4.72149-4.18028,1.55462-7.57748c-1.26672-1.3704-.70245-9.4891.85217-19.9916,3.3972-23.17,11.539-57.948,15.06282-57.45287a19.54689,19.54689,0,0,1,13.94574-14.90158l11.4814-3.15535,2.04979-8.09571h16.16838l2.80988,5.32034,11.78075,5.32041.14972.06909.36851.16117.13819.43761s-.01153.01153,0,.01153l6.55255,20.57892C485.49929,450.05236,485.38416,469.83667,484.6356,487.60571Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <path d="M512.16765,529.07319l-10.9483-19.87361,7.2357-2.9639,14.07224,16.5491a7.59559,7.59559,0,1,1-10.35964,6.28841Z" transform="translate(-238.77402 -267.90176)" fill="#ffb6b6" />
            <path d="M475.34424,425.2497c1.9475,3.49919,19.75792,12.49871,16.67128,21.53373,0,0,16.73218,52.348,18.908,52.00635s4.29947,5.06555,4.29947,5.06555-.46158,3.52907.89553,2.06253,1.03239,2.37773,1.03239,2.37773-.65042,3.39305,1.0727,2.47059-.54247,5.57093-.54247,5.57093L507.32587,521.213l-1.96779-2.92884s-4.20493-.80078-2.22634-1.43511-1.8606-2.76931-1.8606-2.76931-4.01647-2.72969-3.45669-7.25035-10.42269-13.4076-10.42269-13.4076c-7.54974-14.90624-11.68-30.21038-11.66557-45.9969Z" transform="translate(-238.77402 -267.90176)" fill="#04b102" />
            <circle cx="212.68458" cy="126.11822" r="16.01533" fill="#ffb6b6" />
            <path d="M434.87483,395.76478c.50707,3.48013,3.47319,8.33563,2.77855,8.33563s-5.63349-14.34655-.69464-15.282c3.5824-.67853,4.38316-.08335,7.73131-1.53516l-.47235.44458c2.21589,1.61156,5.30008.61823,7.82853-.43068,2.53544-1.04195,5.61267-2.03528,7.83552-.43067,1.39622,1.00723,1.98665,2.75769,2.85494,4.24422.8683,1.49349,2.47291,2.90358,4.12615,2.44514a3.2662,3.2662,0,0,0,2.08391-3.23008c-.007-1.37537-1.7979-2.68377-1.19476-3.91776,1.78743-3.65687.18-6.14945-3.71633-7.8702q-2.12556-.323-4.25117-.65991a12.05736,12.05736,0,0,1,2.66742-2.68129,6.095,6.095,0,0,0-2.1534-2.75773,6.75958,6.75958,0,0,0-3.84827-.5557q-4.397.2292-8.78717.45844a15.50016,15.50016,0,0,0-6.34894,1.23647c-2.41737,1.24339-4.00112,3.66766-5.15424,6.13366C433.57587,385.25492,433.98568,389.71452,434.87483,395.76478Z" transform="translate(-238.77402 -267.90176)" fill="#2f2e41" />
            <path d="M835.501,385.26038H594.65038a1,1,0,0,1,0-2H835.501a1,1,0,0,1,0,2Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M835.501,447.26038H594.65038a1,1,0,0,1,0-2H835.501a1,1,0,0,1,0,2Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M835.501,509.25989H594.65038a1,1,0,0,1,0-2H835.501a1,1,0,0,1,0,2Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M871.34975,505.29571a36.99814,36.99814,0,0,1-24.04583-8.87946c-2.23542-1.91351-4.61728-5.24016-7.07922-9.88687a22.61063,22.61063,0,0,1-.71712-19.52,25.94482,25.94482,0,0,1-4.28456,3.51434l-.78332.52119-.04525-.93927c-.0297-.61092-.04474-1.21978-.04474-1.80962,0-3.47617,2.62916-7.00353,1.41661-10.21662-5.11059-13.54237-21.3201-27.00077,2.17243-47.95951,2.1732-1.93881-.72984-5.81521-.72984-8.74859,0-28.74783,40.63049-78.48249,52.146-52.1358,14.20149,32.49212,38.66868,29.0167,49.50789,35.72792l.15724.47478-.46333.18744a27.94531,27.94531,0,0,1-7.42493,1.97483,35.40687,35.40687,0,0,0,8.27909.69359l.43068-.01505.1049.4186a52.37377,52.37377,0,0,1,1.55456,12.67369l-.00192.46179a23.09253,23.09253,0,0,0,7.62843,17.21859A37.08367,37.08367,0,0,1,961.226,446.4161c0,6.09444-4.14211,14.09442-7.617,19.73247a11.158,11.158,0,0,1-8.19115,5.24658,10.89679,10.89679,0,0,1-8.79423-2.84094,36.036,36.036,0,0,0,6.35491,8.99722l.47413.48854-.58868.343a36.971,36.971,0,0,1-18.63752,5.03317l-.38349-.001a36.091,36.091,0,0,0-25.89133,10.56773A37.27947,37.27947,0,0,1,871.34975,505.29571Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M858.62018,563.8901a.66537.66537,0,0,1-.65794-.57162,222.78689,222.78689,0,0,1-.31039-46.71056c2.29665-24.51173,9.67211-59.81725,31.76611-88.81311a.66542.66542,0,1,1,1.05854.80663c-21.90317,28.74547-29.21917,63.79193-31.49963,88.13059a221.27956,221.27956,0,0,0,.30292,46.39887.666.666,0,0,1-.65961.7592Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
            <path d="M876.65019,468.6948a.66541.66541,0,0,1-.39173-1.20367,91.70936,91.70936,0,0,1,20.24621-10.30643c11.1702-4.08948,28.15614-7.79687,45.64287-2.23145a.66533.66533,0,1,1-.40353,1.268c-17.12847-5.45105-33.80651-1.805-44.78176,2.21325a90.20269,90.20269,0,0,0-19.92141,10.13315A.66278.66278,0,0,1,876.65019,468.6948Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
            <path d="M846.19588,392.84452a.66541.66541,0,0,1,1.17233-.4774,91.7099,91.7099,0,0,1,11.7377,19.45143c4.88328,10.84668,9.80428,27.52154,5.51262,45.36366a.66533.66533,0,1,1-1.29376-.31117c4.20339-17.47655-.6343-33.84872-5.43247-44.5061A90.20263,90.20263,0,0,0,846.35082,393.225.66277.66277,0,0,1,846.19588,392.84452Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
            <path d="M302.04837,491.98387A36.091,36.091,0,0,0,276.157,481.41614l-.38349.001A36.971,36.971,0,0,1,257.136,476.384l-.58868-.343.47413-.48854a36.036,36.036,0,0,0,6.35491-8.99722,10.89679,10.89679,0,0,1-8.79423,2.84094,11.158,11.158,0,0,1-8.19115-5.24658c-3.47488-5.63805-7.617-13.638-7.617-19.73247a37.08367,37.08367,0,0,1,12.09851-27.36438,23.09253,23.09253,0,0,0,7.62843-17.21859l-.00192-.46179a52.37377,52.37377,0,0,1,1.55456-12.67369l.1049-.4186.43068.015a35.40633,35.40633,0,0,0,8.27909-.69358,27.94531,27.94531,0,0,1-7.42493-1.97483l-.46333-.18744.15724-.47478c10.83921-6.71122,35.3064-3.2358,49.50789-35.72792,11.51546-26.34669,52.14595,23.388,52.14595,52.1358,0,2.93338-2.903,6.80978-.72984,8.74859,23.49253,20.95874,7.283,34.41714,2.17243,47.9595-1.21255,3.2131,1.41661,6.74046,1.41661,10.21662,0,.58984-.015,1.19871-.04474,1.80963l-.04525.93927-.78332-.52119a25.94435,25.94435,0,0,1-4.28456-3.51435,22.61065,22.61065,0,0,1-.71712,19.52c-2.46194,4.64671-4.8438,7.97336-7.07922,9.88687a36.96338,36.96338,0,0,1-50.64771-2.43341Z" transform="translate(-238.77402 -267.90176)" fill="#e6e6e6" />
            <path d="M341.37982,561.89113a.66538.66538,0,0,0,.65794-.57162,222.78689,222.78689,0,0,0,.31039-46.71056c-2.29665-24.51173-9.67211-59.81725-31.76611-88.81311a.66542.66542,0,1,0-1.05854.80663c21.90317,28.74546,29.21917,63.79193,31.49963,88.13059a221.27956,221.27956,0,0,1-.30292,46.39887.666.666,0,0,0,.65961.7592Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
            <path d="M323.34981,466.69582a.6654.6654,0,0,0,.39173-1.20366,91.70936,91.70936,0,0,0-20.24621-10.30643c-11.1702-4.08948-28.15614-7.79687-45.64287-2.23145a.66533.66533,0,1,0,.40353,1.268c17.12847-5.451,33.80651-1.80495,44.78176,2.21326a90.20269,90.20269,0,0,1,19.92141,10.13315A.66284.66284,0,0,0,323.34981,466.69582Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
            <path d="M353.80412,390.84555a.6654.6654,0,0,0-1.17233-.4774,91.7099,91.7099,0,0,0-11.7377,19.45143c-4.88328,10.84668-9.80428,27.52154-5.51262,45.36366a.66533.66533,0,1,0,1.29376-.31117c-4.20339-17.47655.6343-33.84872,5.43247-44.5061A90.20231,90.20231,0,0,1,353.64918,391.226.66277.66277,0,0,0,353.80412,390.84555Z" transform="translate(-238.77402 -267.90176)" fill="#3f3d56" />
        </svg>

    </div>
    <script>
        function redirect() {
            window.location.href = "http://localhost/webapp/register.php";
        }

        function redirectUpload() {
            window.location.href = "http://localhost/webapp/upload.html";
        }
    </script>
</body>

</html>