<?php
/*
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

*/

function checkData($data) {
    if(empty($data)){
        header("Location: index.php");
        exit();
    }
    $data = trim($data);
    return $data;
}

if (isset($_POST["class"]) && isset($_POST["date"]) && isset($_POST["timeFrom"]) && isset($_POST["timeTo"])) {
    $class = checkData($_POST["class"]);
    $date = checkData($_POST["date"]);
    $timeFrom = checkData($_POST["timeFrom"]);
    $timeTo = checkData($_POST["timeTo"]);
    
    
    if(strlen($timeFrom)!=4 || strlen($timeTo)!= 4 || $class<=0){
        header("Location: index.php");
        exit();
    }



    $timeConc = $timeFrom . $timeTo;
    #$sql = "INSERT INTO ExtraLesson (ELdate, ELtime, CID)
    #VALUES ($date, $timeConc, $class)";



    echo "Submission successful!<br>";
    echo "Class: ". $class. "<br>Date: "  .$date.  "<br>Time: " . $timeConc;
}else{
    header("Location: index.php");
    exit();
}


?>