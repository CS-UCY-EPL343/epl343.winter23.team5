<?php

  // This code is to list all the unenrolled students
if(isset($_POST["student list"])){

  // Retrieve form data using $_POST
  include "../classes/DatabaseHandler.php";
  $database = new DBh();

  // Select sp and exec
  $sql = "CALL get_unenrolled()";
  $params = [];
  $query = $database->executeQuery($sql, $params);

  if ($query == false){
    $query = null;
    header("Location: enrollView.php?query_error");
    exit();
  }

  echo "<ul>";

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);
  foreach ($rows as $row)
    echo "<li>$row[Fname] $row[Lname] $row[username]</li>";
  $query->closeCursor();

  echo "</ul>";

}
?>
