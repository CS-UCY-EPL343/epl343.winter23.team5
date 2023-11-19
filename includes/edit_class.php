<?php
session_start();
/*
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Teacher"){
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

<h2>List classes</h2>

<form action="edit_class.php" method="post">
    <button type="submit" id="classes_list" name="classes_list">Fetch</button>
</form>

<?php

require '../classes/user.php';
require '../classes/DatabaseHandler.php';
$serialized = $_SESSION['user'];
$teacher = unserialize($serialized);


if(isset($_POST["show_classes"])){
  // Retrieve form data using $_POST

}
?>


</form>

</body>
</html>
