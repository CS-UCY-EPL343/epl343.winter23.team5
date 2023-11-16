<?php
session_start();
if($_SESSION['timeError']==true){
    echo"Faild to submit<br>";
    echo"Start time must be before finish time";
    $_SESSION['timeError']=false;
}
else{
    header("Location: temp.php");
    exit();
}
?>