<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student homepage</title>
</head>

<body>
<h1>Student homepage</h1>

    <form action="../classes/showExtraLessons.php" method="POST">
        <input type="submit" name="showExtraLessons" value="Show extra lessons">
    </form>

    <form action="../includes/delete.inc.php" method="POST">
        <input type="submit" name="delete" value="delete">
    </form>

</body>

</html>
