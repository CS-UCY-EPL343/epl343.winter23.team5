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
    <title>Edit class</title>
</head>

<body>

<h1>List classes</h1>

<?php

require_once '../classes/user.php';
require_once '../classes/class.php';

$serialized = $_SESSION['user'];
$teacher = unserialize($serialized);

$database = new Dbh();
$sql = "CALL find_teaching_classes(:username)";
$params = [":username" => $teacher->getUsername()];

$query = $database->executeQuery($sql, $params);
if ($query == false){
  $query = null;
  header("Location: editClassView.php?query_error");
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

<h1>Edit class</h1>

<form action="../includes/edit_class.php" method="post">
    <label for="class">Class ID:</label>
    <input type="number" id = "class"name="class" required><br>

    <label for="name">Class Name:</label>
<select id="name" name="name" required>
    <option value="C">Chemistry</option>
    <option value="P">Physics</option>
    <option value="M">Math</option>
</select><br>

    <label for="school_year">School Year:</label>
<select id="school_year" name="school_year" required>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
</select><br>

    <label for="code">Group:</label>
    <input type="text" id="code" name="code" required><br>

    <label for="available_seats">Available seats:</label>
    <input type="number" id="available_seats" name="available_seats" required><br>
    <br>
    <label for="First day">First day:</label>
<select id="first_day" name="first_day" required>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
</select><br>

    <label for="from1">From:</label>
    <input type="time" id="from1" name="from1" required><br>

    <label for="until1">Until:</label>
    <input type="time" id="until1" name="until1" required><br>

    <br>

    <label for="Second day">Second day:</label>
<select id="second_day" name="second_day" required>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
</select><br>

    <label for="from2">From:</label>
    <input type="time" id="from2" name="from2" required><br>

    <label for="until2">Until:</label>
    <input type="time" id="until2" name="until2" required><br>

    <label for="next_years">Next year's schedule:</label>
    <input type="checkbox" id="next_years" name="next_years"><br>

    <input type="submit" name="edit_class" value="Edit Class">
</form>

<h1>Assign students</h1>

<form action="../includes/assign_students.php" method="post">
    <label for="class">Class ID:</label>
    <input type="number" id = "class"name="class" required><br>

    <input type="submit" name="assign_students" value="Assign students">
</form>

</body>
</html>
