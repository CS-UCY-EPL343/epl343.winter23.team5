<?php

// This page is were info is sent to enroll student.

if(isset($_POST["enroll"])){

  include "../classes/DatabaseHandler.php";
  include "../classes/User.php";

      // Grab the information
      $username = $_POST["username"];

      // Instancite SignupContr class
      include "../classes/DatabaseHandler.php";
      include "../classes/User.php";
  
      session_start();
  
      $zipAdmin = $_SESSION['user'];
      $admin = unserialize($zipAdmin);
  
      $admin -> enrollStudent($username);
}
?>