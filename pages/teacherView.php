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
    <title>Document</title>
</head>

<h1>Teacher homepage</h1>

<body>
    <form action="../includes/delete.inc.php" method="POST">
        <input type="submit" name="delete" value="delete">
    </form>

<a href="extraLessonView.php">Add extra lesson</a><br>

</body>

</html>
