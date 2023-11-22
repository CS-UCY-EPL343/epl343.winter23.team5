<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Class</title>
</head>
<body>


<?php
    
if(isset($_POST["delete_class"])){
  $classes = $_SESSION['classes'];
  $class = $_POST['class'];
  $class_id = $classes[$class - 1]["CID"];

  require_once "../classes/class.php";
  _Class::delete_class($class_id);
  echo "Succesfully deleted class<br>";
}
?>

</body>

</html>
