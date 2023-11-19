<?php
session_start();
if ($_SESSION['student'] == false) {
    header('Location: index1.php');
    exit();
}



include 'user.php';
include 'DatabaseHandler.php';
$serialized = $_SESSION['user'];
$retrievedUser = unserialize($serialized);




$database = new Dbh();
if ($database == null) {
    echo 'Failed connection';
} else {
    #echo 'Successful connection';
}
$sql = "CALL show_extra_lesson(:username)";
$params = [':username' => $retrievedUser->getUsername()];
$sqlResult = $database->executeQuery($sql, $params);

if ($sqlResult == false) {
    echo 'Error!';
}
$result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
$sqlResult->closeCursor();
if (count($result) == 0) {
    echo 'You do not have any extra lessons!';
} else {
    #!!!!!!! No Extra Lessons? !!!!!!!!
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
        echo "Extra Lesson $i: " . $row['ELDate'] . " $time, $CName, Grade " . $row['CNumber'] . "<br>";
        $i++;
    }
}


?>