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

<h1>Current students</h1>

<?php

if(isset($_POST["assign_students"])){

  require_once '../classes/DatabaseHandler.php';

  $class_id = $_POST["class"];
  $_SESSION["class"] = $class_id;

  $database = new Dbh();
  $sql = "CALL fetch_class_students(:cid)";
  $params = [":cid" => $class_id];

  $query = $database->executeQuery($sql, $params);
  if ($query == false){
    $query = null;
    header("Location: assign_students.php?query_error");
    exit();
  }

  //echo "<ul>";

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);

  $i = 1;
  echo "First name, Last name, username<br>";
  foreach ($rows as $row){
    echo "$row[Fname] $row[Lname] $row[username]<br>";
    $i++;
  }
  $query->closeCursor();

  //echo "</ul>";
}
?>

<h1>Other students</h1>

<?php

if(isset($_POST["assign_students"])){

  require_once '../classes/DatabaseHandler.php';

  $class_id = $_SESSION["class"];

  $database = new Dbh();
  $sql = "CALL fetch_other_students(:cid)";
  $params = [":cid" => $class_id];

  $query = $database->executeQuery($sql, $params);
  if ($query == false){
    $query = null;
    header("Location: assign_students.php?query_error2");
    exit();
  }

  //echo "<ul>";

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);

  $i = 1;
  echo "First name, Last name, username<br>";
  foreach ($rows as $row){
    echo "$row[Fname] $row[Lname] $row[username]<br>";
    $i++;
  }
  $query->closeCursor();

}
?>

<form action="../includes/assign_students.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id = "username"name="username" required><br>

    <input type="submit" name="assign" value="Assign">
</form>

<?php

if(isset($_POST["assign"])){
  require_once "../classes/class.php";
  _Class::assign_student($_POST["username"], $_SESSION["class"]);
}
?>

</body>
</html>
