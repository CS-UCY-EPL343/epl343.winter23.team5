<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Teacher"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include_once '../classes/user.php';
    include_once '../classes/DatabaseHandler.php';
    $serialized = $_SESSION['user'];
    $retrievedUser = unserialize($serialized);

    function checkData($data)
    {
        if (empty($data)) {
            $_SESSION['message'] = 'Empty Fields!<br>Failed Submission';
            header("Location: ../pages/extraLessonView.php");
            exit();
        }
        $data = trim($data);
        return $data;
    }
    $class = checkData($_POST["class"]);
    $date = checkData($_POST["date"]);
    $timeFrom = checkData($_POST["timeFrom"]);
    $timeTo = checkData($_POST["timeTo"]);

    if ($timeFrom >= $timeTo) {
        $_SESSION['message'] = 'Start time must be before finish time!<br>Failed Submission';
        header("Location: ../pages/extraLessonView.php");
        exit();
    }

    $formattedTimeFrom = date('Hi', strtotime($timeFrom));
    $formattedTimeTo = date('Hi', strtotime($timeTo));
    $timeConc = $formattedTimeFrom . $formattedTimeTo;

    $classes = $_SESSION['classes'];

    if ($class < 1 || $class > count($classes)) {
        $_SESSION['message'] = 'You do not teach this class!<br>Failed Submission';
        header("Location: ../pages/extraLessonView.php");
        exit();
    }

    $database = new Dbh();
    $sql = "CALL insert_extra_lesson(:ELDate, :ELTime, :CID)";
    $params = [':ELDate' => $date, ':ELTime' => $timeConc, ':CID' => $classes[$class - 1]['CID']];
    $sqlResult = $database->executeQuery($sql, $params);

    if ($sqlResult == false) {
      $sqlResult = null;
      header("location: extraLessonView.php?query_error");
      exit();
    }
    $sqlResult->closeCursor();

    $_SESSION['message'] = 'Submission Successful!';
    header("Location: ../pages/extraLessonView.php");
    exit();
}


?>
