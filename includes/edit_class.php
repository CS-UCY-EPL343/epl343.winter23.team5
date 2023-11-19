<?php
session_start();
/*
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Teacher"){
  header("Location: index.html?error");
  exit("Not supposed to be here...");
}
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
</head>
<body>

<h2>List classes</h2>

<form action="edit_class.php" method="post">
    <button type="submit" id="classes_list" name="classes_list">Fetch</button>
</form>

<?php

if(isset($_POST["classes_list"])){
  require '../classes/user.php';
  require '../classes/class.php';
  /*
  $serialized = $_SESSION['user'];
  $teacher = unserialize($serialized);
  */
  $database = new Dbh();
  $sql = "CALL find_teaching_classes(:username)";
  //$params = [":username" => $teacher->getUsername()];
  $params = [":username" => "alicejohnson"];

  $query = $database->executeQuery($sql, $params);
  if ($query == false){
    $query = null;
    header("Location: new_class.php?query_error");
    exit();
  }

  //echo "<ul>";

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);
  foreach ($rows as $row){
    $class_instance = new _Class($row["CName"], $row["SchoolYear"], $row["CNumber"],
    $row["AvailableSeats"], $row["CDays"], $row["TimeForFirstDay"], $row["TimeForSecondDay"],
    $row["NextYears"], $row["CID"]);
    $class_instance->display_class();
    echo "<br>";
  }
  $query->closeCursor();

  //echo "</ul>";
}
?>


</form>

</body>
</html>
