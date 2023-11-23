<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
// This is the file our data is sent in order to delete account.

  include "../classes/user.php";

  $zipUser = $_SESSION['user'];
  $user = unserialize($zipUser);

  $user -> deleteAccount();



/*

if(isset($_POST["delete"]))
{
    // Instancite SignupContr class
    include "../classes/user.php";

    $zipUser = $_SESSION['user'];
    $user = unserialize($zipUser);

    $user -> deleteAccount();

}


*/
?>

