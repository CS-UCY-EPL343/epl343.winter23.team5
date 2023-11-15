<?php


if (isset($_POST["class"]) && isset($_POST["date"]) && isset($_POST["timeFrom"]) && isset($_POST["timeTo"])) {
    session_start();
    include 'user.php';
    $serialized = $_SESSION['user'];
    $retrievedUser = unserialize($serialized);

    function checkData($data) {
        if(empty($data)){
            header("Location: index.php");
            exit();
        }
        $data = trim($data);
        return $data;
    }
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


    echo "Hello " . $retrievedUser->getUsername() . "<br>";
    echo "Submission successful!<br>";
    echo "Class: ". $class. "<br>Date: "  .$date.  "<br>Time: " . $timeConc;
}else{
    header("Location: index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>