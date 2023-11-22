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
    <title>Edit Class</title>
</head>
<body>


<?php
    
if(isset($_POST["edit_class"])){
  $classes = $_SESSION['classes'];
  $class = $_POST['class'];
  $class_id = $classes[$class - 1]["CID"];
  $_SESSION["class_id"] = $class_id;

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
  require_once "../classes/class.php";
  $class_instance = new _Class($name, $school_year, $code, $available_seats, $week,
                      $day1, $day2, $next_years, $class_id);
  $class_instance->edit_class();
  $serialized = serialize($class_instance);
  
  // Display class details
  $class_instance->display_class();
}
?>

</body>

</html>
