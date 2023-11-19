<?php
session_start();
/*
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Admin"){
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
    <title>Create Class</title>
</head>
<body>

<h2>Create Class</h2>

<?php

include('create_class_form.html');

if(isset($_POST["create_class"])){
  // Retrieve form data using $_POST
  $name = $_POST["name"];
  $school_year = $_POST["school_year"];
  $code = $_POST["code"];
  $available_seats = $_POST["available_seats"];

  $first_day = $_POST["first_day"];
  $from1 = $_POST["from1"];
  $until1 = $_POST["until1"];

  $second_day = $_POST["second_day"];
  $from2 = $_POST["from2"];
  $until2 = $_POST["until2"];
  $next_years = isset($_POST["next_years"]) ? 1 : 0;

  $daysMap = [
    "Monday"    => 0,
    "Tuesday"   => 1,
    "Wednesday" => 2,
    "Thursday"  => 3,
    "Friday"    => 4,
    "Saturday"  => 5,
    "Sunday"    => 6,
  ];

  $week = "0000000";
  $week[$daysMap[$first_day]] = '1';
  $week[$daysMap[$second_day]] = '1';

  $day1 = substr($from1, 0, 2) . substr($from1, 3) . substr($until1, 0, 2) . substr($until1, 3);
  $day2 = substr($from2, 0, 2) . substr($from2, 3) . substr($until2, 0, 2) . substr($until2, 3);

  // class instance
  require "../classes/class.php";
  $class_instance = new _Class($name, $school_year, $code, $available_seats, $week,
                      $day1, $day2, $next_years);
  $class_instance->store_class();
  $serialized = serialize($class_instance);
  $_SESSION["class_instance"] = $serialized;
  
  // Display class details (this is just an example, you might want to redirect or perform other actions)
  //$class_instance->display_class();
}
?>

<h2>List tutors</h2>

<form action="new_class.php" method="post">
    <button type="submit" id="teachers_list" name="teachers_list">Fetch</button>
</form>

<?php
  // assign tutor section
if(isset($_POST["teachers_list"])){
  // Retrieve form data using $_POST
  require "../classes/DatabaseHandler.php";
  $database = new DBh();

  // Select sp and exec
  $sql = "CALL fetch_teachers()";
  $params = [];
  $query = $database->executeQuery($sql, $params);

  if ($query == false){
    $query = null;
    header("Location: new_class.php?query_error");
    exit();
  }

  echo "<ul>";

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);
  foreach ($rows as $row)
    echo "<li>$row[Fname] $row[Lname] $row[username]</li>";
  $query->closeCursor();

  echo "</ul>";
}
?>

<h2>Assign tutor to class</h2>

<form action="new_class.php" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    <button type="submit" id="assign_teacher" name="assign_teacher">Assign</button>
</form>

<?php
if(isset($_POST["assign_teacher"])){
  require "../classes/class.php";

  $username = $_POST["username"];
  $serialized = $_SESSION["class_instance"];
  $class_instance = unserialize($serialized);
  $class_instance->assign_teacher($username);
}
?>

</form>

</body>
</html>
