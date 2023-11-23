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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Delete class</title>
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
                <a href="../pages/adminView.php" class="btn btn-primary">Go Back</a>
            </div>
        </header>
        <?php
        // If deletion from databse was successfull.
        if (isset($_SESSION["delete"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo "Deleted successfully!";
            ?>
        </div>
        <?php
        unset($_SESSION["delete"]);
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

        $database = new Dbh();
        $sql = "CALL get_all_classes()";
        $params = [];

        $query = $database->executeQuery($sql, $params);
        if ($query == false){
          $query = null;
          header("Location: deleteClassView2.php?query_error");
          exit();
        }

        //echo "<ul>";

        $rows = $query->fetchALL(PDO::FETCH_ASSOC);
        $_SESSION['classes'] = $rows;

        $i = 1;
        foreach ($rows as $row){
          /*
          $obj = new _Class($row["CName"], $row["SchoolYear"], $row["CNumber"],
            $row["AvailableSeats"], $row["CDays"], $row["TimeForFirstDay"], $row["TimeForSecondDay"],
            $row["NextYears"], $row["CID"]);
          /*
          echo "Class ID: $i<br>";
          $class_instance->display_class();
          echo "<br>";
          */
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
                    <a href="../includes/delete_class.php?cid=<?php echo $cid; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
          <?php
          $i++;
        }
        $query->closeCursor();

        //echo "</ul>";
        // Clear query and close cursor

        ?>
        </tbody>
        </table>
    </div>
</body>
</html>
