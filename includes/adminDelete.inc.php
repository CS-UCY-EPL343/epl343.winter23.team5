<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
// This is the file our data is sent in order to delete a Students or teachers account.

//Check if we accesed the page using the button not by URL
if(isset($_POST["delete"]))
{
    // Grab the information
    $username = $_POST["username"];

    // Instancite SignupContr class
    include "../classes/user.php";

    session_start();

    $zipAdmin = $_SESSION['user'];
    $admin = unserialize($zipAdmin);

    $admin -> deleteOtherAccount($username);
}

?>
