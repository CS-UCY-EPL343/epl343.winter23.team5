<?php
session_start();
if($_SESSION['ELsuccess']==true){
    echo "Submission successful!<br>";
    $_SESSION['ELsuccess']=false;
}
else{
    header("Location: temp.php");
    exit();
}
?>