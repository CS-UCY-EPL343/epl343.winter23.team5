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
    <title>Add extra lesson</title>
</head>

<body>
    <form action="../classes/extraLesson.php" method="POST">
        Class Number: <input type="number" name="class" required><br>
        Date: <input type="date" name="date" required><br>
        Start Time: <input type="time" name="timeFrom" required><br>
        Finish Time: <input type="time" name="timeTo" required><br>
        <input type="submit" name="submit" value="submit">
    </form>

    <?php
    if (isset($_SESSION['message'])){
        echo $_SESSION['message'];
        $_SESSION['message'] = '';
    }

    include '../classes/user.php';
    include '../classes/class.php';
    $serialized = $_SESSION['user'];
    $retrievedUser = unserialize($serialized);

    echo '<h1>Your Classes are:<h1/>';

    $database = new Dbh();
    $sql = "CALL find_teaching_classes(:username)";
    $params = [':username' => $retrievedUser->getUsername()];

    $sqlResult = $database->executeQuery($sql, $params);
    if ($sqlResult == false) {
      $sqlResult = null;
      header("location: extraLessonView.php?query_error");
      exit();
    }
    $result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['classes'] = $result;

    $i = 1;
    foreach ($result as $row){
      echo "Class: $i<br>";
      $class_instance = new _Class($row["CName"], $row["SchoolYear"], $row["CNumber"],
        $row["AvailableSeats"], $row["CDays"], $row["TimeForFirstDay"], $row["TimeForSecondDay"],
        $row["NextYears"], $row["CID"]);
      $class_instance->display_class();
      echo "<br>";
      $i++;
    }

    $sqlResult->closeCursor();


?>
</body>

</html>
