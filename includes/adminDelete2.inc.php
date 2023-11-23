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
    $admin -> removeAccount($username);    

}else{
    
    echo "no user found";
}