<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Teacher"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign students</title>
</head>

<body>

<?php

if(isset($_GET["username"])){
  require_once "../classes/class.php";
  _Class::assign_student($_GET["username"], $_SESSION["cid"]);
  $_SESSION["assign"] = $_GET["username"]." assigned successfully!";
  header("Location: ../pages/assignStudents.php?cid=".$_SESSION["cid"]);
}
?>

</body>
</html>
