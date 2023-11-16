<?php
session_start();
if($_SESSION['classError']==true){
    echo"Faild to submit<br>";
    echo"You do not teach that class";
    $_SESSION['classError']=false;
}
else{
    header("Location: temp.php");
    exit();
}
?>