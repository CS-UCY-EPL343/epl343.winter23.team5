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
    <title>Document</title>
</head>

<h1>Admin Homepage</h1>

<body>

<a href="createClassView.php">Create class page</a><br>

    <form action="../includes/adminDelete.inc.php" method="POST">
    Username: <input type="text" name="username" require><br>
    <input type="submit" name="delete" value="delete">

    </form>

</body>

</html>
