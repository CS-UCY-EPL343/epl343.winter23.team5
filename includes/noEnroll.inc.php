<?php

// We delete user here from database.
require_once "../classes/DatabaseHandler.php";

if (isset($_GET['username'])) {

    $username = $_GET['username'];

    // Instancite User class
    require_once "../classes/user.php";
    
    session_start();

    $zipAdmin = $_SESSION['user'];
    $admin = unserialize($zipAdmin);
    $admin -> declineEnrollment($username);    

}else{
    
    echo "no user found";
}

/*

    //Connect to database using handler
    $database = new Dbh();
    
    // Check if user exists.
    $sql = "CALL delete_user(:username)";
    $params = [':username' => $username];
    $sqlResult = $database->executeQuery($sql, $params);

    // Check if error occured w/ stmt
    if($sqlResult == false){
        $sql = null;
        $sqlResult->closeCursor();
        header("location: ../pages/enrollView2.php?error=stmtfailed");
        exit();
    }else{
        session_start();
        $_SESSION["delete"] = $username." was deleted Successfully!";
        header("Location:../pages/enrollView2.php");
    }

*/
?>