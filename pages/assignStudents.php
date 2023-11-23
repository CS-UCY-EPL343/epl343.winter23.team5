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
    <title>Assign students</title>
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
            <h1>Assign students</h1>
            <div>
                <a href="../pages/editClassView2.php" class="btn btn-primary">Go Back</a>
            </div>
        </header>
<?php
// If deletion from databse was successfull.
if (isset($_SESSION["assign"])) {
?>
        <div class="alert alert-success">
<?php 
  echo $_SESSION["assign"];
?>
        </div>
<?php
  unset($_SESSION["assign"]);
}
?>

        <h3>Current students</h3>
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>

<?php
require_once '../classes/DatabaseHandler.php';

$class_id = $_GET["cid"];
$_SESSION["cid"] = $class_id;

$database = new Dbh();
$sql = "CALL fetch_class_students(:cid)";
$params = [":cid" => $class_id];

$query = $database->executeQuery($sql, $params);
if ($query == false){
  $query = null;
  header("Location: assignStudents.php?query_error");
  exit();
}

$rows = $query->fetchALL(PDO::FETCH_ASSOC);

$i = 1;
foreach($rows as $row){
?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['Fname']; ?></td>
                <td><?php echo $row['Lname']; ?></td>
                <td><?php echo $row['username']; ?></td>
            </tr>
<?php
  $i++;
}

// Clear query and close cursor
$query->closeCursor();

?>
        </tbody>
        </table>

        <h3>Other students</h3>

        <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
<?php
require_once '../classes/DatabaseHandler.php';

$class_id = $_SESSION["cid"];

$database = new Dbh();
$sql = "CALL fetch_other_students(:cid)";
$params = [":cid" => $class_id];

$query = $database->executeQuery($sql, $params);
if ($query == false){
  $query = null;
  header("Location: assignStudents.php?query_error2");
  exit();
}
$rows = $query->fetchALL(PDO::FETCH_ASSOC);

$i = 1;
foreach($rows as $row){
?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['Fname']; ?></td>
                <td><?php echo $row['Lname']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td>
                  <a href="../includes/assign_students.php?username=<?php echo $row['username']; ?>" class="btn btn-info">Assign</a>
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
