<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}

if(isset($_GET["username"])){
  require_once "../classes/class.php";

  $username = $_GET["username"];
  $serialized = $_SESSION["class_instance"];
  $class_instance = unserialize($serialized);
  $class_instance->assign_teacher($username);

  //$_SESSION["assign"] = $username." assigned to class succ";
  header("Location: ../pages/adminView.php?ELsuccess");
}
?>
