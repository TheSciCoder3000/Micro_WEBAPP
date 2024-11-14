<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>

<body>

<?php
$studentname="";
$studentnameErr="";
$mobileErr="";
$mobilelenErr="";
$emailErr="";
$yearlevelErr="";




if (empty($_POST['studentname'])){
    $studentnameErr = "<h1>name is required</h1>";
}

if (empty($_POST['mobilenumber'])){
    $mobileErr = "<h1>mobile is required</h1>";
} else {
    $mobile = $_POST['mobilenumber'];
    if(strlen($mobile)!=10){
        $mobilelenErr = "<h1>mobile should be 10 digits</h1>";
    }
}

if (empty($_POST['email'])){
    $emailErr = "<h1>email address is required</h1>";
}

if (empty($_POST['yearlevel'])){
    $yearlevelErr = "<h1>year level is required</h1>";
}


?>


    <h1>Registration Form</h1>

    <form id= "registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <label for="">Student Name:</label><input type="text " id="studentname" name="studentname"><br>
        <label for="">Email:</label><input type="email" name="email" id="email"><br>
        <label for="">YearLevel:</label><input type="number" name="yearlevel" id="yearlevel"><br>
        <label for="">MobileNumber</label><input type="tel"  name="mobilenumber" id="mobilenumber"><br>
        <input type="submit" value="submit" name="submit"><br>

    </form>


    <button onClick="window.location.reload();" class="button1">Refresh Page</button>

    <button>Reports</button>


</body>



<?php

if(isset($_POST['submit'])){

    if($mobileErr==""&&$studentnameErr==""&&$mobilelenErr==""&&$emailErr==""&&$yearlevelErr==""){
    
        $serverName="NeurosLaptop\SQLEXPRESS"; 
        $connectionOptions=[ 
            "Database"=>"WebApp", 
            "Uid"=>"", 
            "PWD"=>"" 
        ]; 
            $conn=sqlsrv_connect($serverName, $connectionOptions); 
            if($conn==false) 
            die(print_r(sqlsrv_errors(),true)); 
            else echo 'Connection Success'."<br/>";
    
        $studentname=$_POST['studentname'];
        $email=$_POST['email'];
        $year=$_POST['yearlevel'];
        $mobile=$_POST['mobilenumber'];
    
        $sql="INSERT INTO STUDENT(STUDENT_NAME,STUDENT_EMAIL,YEAR_LEVEL,MOBILE_NUMBER) VALUES ('$studentname','$email',$year,$mobile)";
        $results=sqlsrv_query($conn, $sql);
        if($results){
            header("Location: /lecture/successpage.php");
            die();
            echo "Registration Successful";
        }else{
            echo'Error';
        }
    
    } else {
        echo $mobileErr;
        echo $studentnameErr;
        echo $mobilelenErr;
        echo $emailErr;
        echo $yearlevelErr;
    }

}
?>