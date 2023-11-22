<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Student"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}



include_once '../classes/user.php';
include_once '../classes/DatabaseHandler.php';
$serialized = $_SESSION['user'];
$retrievedUser = unserialize($serialized);




$database = new Dbh();
$sql = "CALL show_extra_lesson(:username)";
$params = [':username' => $retrievedUser->getUsername()];
$sqlResult = $database->executeQuery($sql, $params);

if ($sqlResult == false) {
  $sqlResult = null;
  header("location: ../pages/studentView.php?query_error");
  exit();
}

$result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
$sqlResult->closeCursor();

if (count($result) == 0) {
    echo 'You do not have any extra lessons!';
} else {
    $i = 1;
    foreach ($result as $row) {
        if ($row['CName'] == 'M') {
            $CName = "Maths";
        } else if ($row["CName"] == "C") {
            $CName = "Chemistry";
        } else if ($row["CName"] == "P") {
            $CName = "Physics";
        }
        $time = substr($row['ELTime'], 0, 4) . "-" . substr($row["ELTime"], 4, 8);
        echo "Extra Lesson $i: " . $row['ELDate'] . " $time, $CName, Group " . $row['CNumber'] . "<br>";
        $i++;
    }
}


?>
