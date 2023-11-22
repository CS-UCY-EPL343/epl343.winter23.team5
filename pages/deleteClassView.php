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
    <title>Edit class</title>
</head>

<body>
<?php

require_once '../classes/user.php';
require_once '../classes/class.php';

$serialized = $_SESSION['user'];
$teacher = unserialize($serialized);

$database = new Dbh();
$sql = "CALL get_all_classes()";
$params = [];

$query = $database->executeQuery($sql, $params);
if ($query == false){
  $query = null;
  header("Location: deleteClassView.php?query_error");
  exit();
}

//echo "<ul>";

$rows = $query->fetchALL(PDO::FETCH_ASSOC);
$_SESSION['classes'] = $rows;

$i = 1;
foreach ($rows as $row){
  $class_instance = new _Class($row["CName"], $row["SchoolYear"], $row["CNumber"],
    $row["AvailableSeats"], $row["CDays"], $row["TimeForFirstDay"], $row["TimeForSecondDay"],
    $row["NextYears"], $row["CID"]);

  echo "Class ID: $i<br>";
  $class_instance->display_class();
  echo "<br>";
  $i++;
}
$query->closeCursor();

//echo "</ul>";
?>

<form action="../includes/delete_class.php" method="post">
    <label for="class">Class ID:</label>
    <input type="number" id = "class"name="class" required><br>

    <input type="submit" name="delete_class" value="Delete Class">
</form>

</body>
</html>
