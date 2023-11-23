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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Edit class</title>
    <style>
        table  td, table th{
        vertical-align:middle;
        text-align:right;
        padding:20px;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <header class="d-flex justify-content-between my-4">
            <h1>Classes</h1>
            <div>
                <a href="../tempPages/teacherpage.html" class="btn btn-primary">Go Back</a>
            </div>
        </header>
        <?php
        #session_start();
        // If deletion from databse was successfull.
        if (isset($_SESSION["edit"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo "Edited successfully!";
            ?>
        </div>
        <?php
        unset($_SESSION["edit"]);
        }
        ?>
        
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Year</th>
                <th>Days</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
        
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
  header("Location: editClassView2.php?query_error");
  exit();
}

$rows = $query->fetchALL(PDO::FETCH_ASSOC);
$_SESSION['classes'] = $rows;

$i = 1;
foreach ($rows as $row){
  $class_instance = new _Class($row["CName"], $row["SchoolYear"], $row["CNumber"],
    $row["AvailableSeats"], $row["CDays"], $row["TimeForFirstDay"], $row["TimeForSecondDay"],
    $row["NextYears"], $row["CID"]);

          $cname = $row["CName"] . $row["CNumber"];
          $week = _Class::binary_to_days($row["CDays"]);
          $time1 = substr($row["TimeForFirstDay"], 0, 4) . "-" . substr($row["TimeForFirstDay"], 4, 8);
          $time2 = substr($row["TimeForSecondDay"], 0, 4) . "-" . substr($row["TimeForSecondDay"], 4, 8);
          $cid = $row["CID"];
          ?> 
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $cname; ?></td>
                <td><?php echo $row["SchoolYear"]; ?></td>
                <td><?php echo "$week[0]<br> $week[1]"; ?></td>
                <td><?php echo "$time1<br> $time2"; ?></td>
                <td>
                    <!-- -->
                    <a href="editClassView.php?cid=<?php echo $cid; ?>" class="btn btn-info">Edit</a>
                    <a href="assignStudents.php?cid=<?php echo $cid; ?>" class="btn btn-warning">Assign students</a>
                </td>
            </tr>
          <?php
  $i++;
}
$query->closeCursor();
        ?>
        </tbody>
        </table>
    </div>
</body>
</html>
