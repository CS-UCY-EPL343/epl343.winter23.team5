<?php
session_start();
if ($_SESSION['teacher'] == false) {
    header('Location: index.php');
    exit();
}

if (isset($_POST["class"]) && isset($_POST["date"]) && isset($_POST["timeFrom"]) && isset($_POST["timeTo"]) && isset($_POST["submit"])) {

    include 'user.php';
    include 'DatabaseHandler.php';
    $serialized = $_SESSION['user'];
    $retrievedUser = unserialize($serialized);

    function checkData($data)
    {
        if (empty($data)) {
            header("Location: temp.php");
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
        header("Location: errorTime.php");
        $_SESSION['timeError'] = true;
        exit();
    }

    $formattedTimeFrom = date('Hi', strtotime($timeFrom));
    $formattedTimeTo = date('Hi', strtotime($timeTo));
    $timeConc = $formattedTimeFrom . $formattedTimeTo;
    #$sql = "INSERT INTO ExtraLesson (ELdate, ELtime, CID)
    #VALUES ($date, $timeConc, $class)";

    $classes = $_SESSION['classes'];

    if ($class < 1 || $class > count($classes)) {
        header("Location: errorClass.php");
        $_SESSION['classError'] = true;
        exit();
    }

    $database = new Dbh();
    $sql = "CALL insert_extra_lesson(:ELDate, :ELTime, :CID)";
    $params = [':ELDate' => $date, ':ELTime' => $timeConc, ':CID' => $classes[$class - 1]['CID']];
    $database->executeQuery($sql, $params);




    header("Location: ELsuccess.php");
    $_SESSION['ELsuccess'] = true;
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        Class Number: <input type="number" name="class"><br>
        Date: <input type="date" name="date"><br>
        Start Time: <input type="time" name="timeFrom"><br>
        Finish Time: <input type="time" name="timeTo"><br>
        <input type="submit" name="submit" value="submit">
    </form>
    <?php
    include 'user.php';
    include 'DatabaseHandler.php';
    $serialized = $_SESSION['user'];
    $retrievedUser = unserialize($serialized);

    echo '<h1>Your Classes are:<h1/>';

    $database = new Dbh();
    $sql = "CALL find_teaching_classes(:username)";
    $params = [':username' => $retrievedUser->getUsername()];

    $sqlResult = $database->executeQuery($sql, $params);
    if ($sqlResult == false) {
        echo 'Error!';
    }
    $result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
    $sqlResult->closeCursor();
    $_SESSION['classes'] = $result;

    $i = 1;
    foreach ($result as $row) {
        if ($row['CName'] == 'M') {
            $CName = "Maths";
        } else if ($row["CName"] == "C") {
            $CName = "Chemistry";
        } else if ($row["CName"] == "P") {
            $CName = "Physics";
        }
        $j = 0;
        $day1;
        $day2;
        $index1=-1;
        $index2=-1;
        $flag = true;
        for ($j = 0; $j < 7; $j++){
            if ($row['CDays'][$j]=="1" && $flag == true){
                $index1=$j;
                $flag = false;
                continue;
            }
            else if ($row['CDays'][$j]=="1" && $flag == false){
                $index2=$j;
            }
        }
        
        $daysMap = [
            0 => "Monday",
            1 => "Tuesday",
            2 => "Wednesday",
            3 => "Thursday",
            4 => "Friday",
            5 => "Saturday",
            6 => "Sunday",
        ];

        if ($index1 == -1){
            $day1 = "Null";
            $time1 = "";
        }
        else{
            $day1 = $daysMap[$index1] ?? null;
            $time1 = substr($row['TimeForFirstDay'], 0, 4) . "-" . substr($row["TimeForFirstDay"], 4, 4);
        }
        if ($index2 == -1){
            $day2 = "";
            $time2 = "";
        }
        else{
            $day2 = $daysMap[$index2] ?? null;
            $day2 = ", " . $day2;
            $time2 = substr($row['TimeForSecondDay'], 0, 4) . "-" . substr($row["TimeForSecondDay"], 4, 4);
        }
        
        
        
        
        echo "Class Number $i: " . $CName . ", Grade " . $row['SchoolYear'] . ", Group " . $row['CNumber'] . ", " . $day1 . " " . $time1 . $day2 . " " . $time2 . "<br>";
        $i = $i + 1;
        echo "<br>";
    }

    ?>
</body>

</html>