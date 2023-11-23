<?php
/*
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Student"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
*/

include_once 'DatabaseHandler.php';

class _Class implements Serializable {
  private $name;
  private $school_year;
  private $code;
  private $available_seats;
  private $week;
  private $day1;
  private $day2;
  private $class_id;
  private $next_years;
  private $teacher; // Assuming a one-to-one relationship for simplicity
  private $students = []; // Assuming a one-to-many relationship for simplicity

  // Constructor
  public function __construct($name, $school_year, $code, $available_seats, $week,
    $day1, $day2, $next_years, $class_id = null) {
    $this->name = $name;
    $this->school_year = $school_year;
    $this->code = $code;
    $this->available_seats = $available_seats;
    $this->week = $week;
    $this->day1 = $day1;
    $this->day2 = $day2;
    $this->class_id = $class_id;
    $this->next_years = $next_years;
    $this->teacher = null;
  }

  public function serialize(){
    return serialize([
      "name" => $this->name,
      "school_year" => $this->school_year,
      "code" => $this->code,
      "available_seats" => $this->available_seats,
      "week" => $this->week,
      "day1" => $this->day1,
      "day2" => $this->day2,
      "class_id" => $this->class_id,
      "next_years" => $this->next_years,
      "teacher" => $this->teacher,
      "students" => $this->students
    ]);
  }

  public function unserialize($data){
    $data = unserialize($data);
    $this->name = $data["name"];
    $this->school_year = $data["school_year"];
    $this->code = $data["code"];
    $this->available_seats = $data["available_seats"];
    $this->week = $data["week"];
    $this->day1 = $data["day1"];
    $this->day2 = $data["day2"];
    $this->class_id = $data["class_id"];
    $this->next_years = $data["next_years"];
    $this->teacher = $data["teacher"];
    $this->students = $data["students"];
  }

  // Function call to store class
  public function store_class(){
    $database = new Dbh();
    // Select sp and exec
    $sql = "CALL add_class(:name, :school_year, :code, :available_seats,
      :week, :day1, :day2, :next_years)";
    $params = [":name" => $this->name, ":school_year" => $this->school_year, ":code" => $this->code, 
      "available_seats" => $this->available_seats, ":week" => $this->week,
      ":day1" => $this->day1, ":day2" => $this->day2,":next_years" => (int)$this->next_years];
    $query = $database->executeQuery($sql, $params);

    if ($query == false){
      $query = null;
      header("Location: ../includes/new_class.php?query_error");
      exit();
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);
    $this->class_id = $row["LAST_INSERT_ID()"];
    $query->closeCursor();
  }
  
  // Function call to delete class
  public static function delete_class($cid){
    $database = new Dbh();
    // Select sp and exec
    $sql = "CALL delete_class(:cid)";
    $params = [":cid" => $cid];
    $query = $database->executeQuery($sql, $params);

    if ($query == false){
      $query = null;
      header("Location: ../index.html?query_error");
      exit();
    }
  }

  // Function to edit class details
  public function edit_class() {
    $database = new Dbh();
    // Select sp and exec
    $sql = "CALL update_class(:class_id, :name, :school_year, :code, :available_seats,
      :week, :day1, :day2, :next_years)";
    $params = [":class_id" => $this->class_id, ":name" => $this->name, ":school_year" => $this->school_year,
      ":code" => $this->code, "available_seats" => $this->available_seats, ":week" => $this->week,
      ":day1" => $this->day1, ":day2" => $this->day2,":next_years" => (int)$this->next_years];
    $query = $database->executeQuery($sql, $params);

    if ($query == false){
      $query = null;
      header("Location: ../includes/edit_class.php?query_error");
      exit();
    }
    $query->closeCursor();
  }

  // Function to assign a teacher to the class
  public function assign_teacher($username) {
    $database = new Dbh();
    // Select sp and exec
    $sql = "CALL get_user(:username)";
    $params = [":username" => $username];
    $query = $database->executeQuery($sql, $params);
    if ($query == false){
      $query = null;
      header("Location: ../includes/new_class.php?query_error1");
      exit();
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row == false){
      header("Location: ../includes/new_class.php?user_not_found");
      $query->closeCursor();
      exit();
    }
    $query->closeCursor();

    $uid = $row["UserID"];
    $cid = $this->class_id;

    // Select sp and exec
    $sql = "CALL insert_to_teaching(:uid, :cid)";
    $params = [":uid" => $uid, ":cid" => $cid];
    $query = $database->executeQuery($sql, $params);

    if ($query == false){
      $query = null;
      header("Location: ../includes/new_class.php?query_error2");
      exit();
    }
    $query->closeCursor();
  }

  // Function to assign a student to the class
  public static function assign_student($username, $cid) {
    $database = new Dbh();
    // Select sp and exec
    $sql = "CALL get_user(:username)";
    $params = [":username" => $username];
    $query = $database->executeQuery($sql, $params);
    if ($query == false){
      $query = null;
      header("Location: ../includes/assign_students.php?query_error1");
      exit();
    }

    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row == false){
      header("Location: ../includes/assign_students.php?user_not_found");
      $query->closeCursor();
      exit();
    }
    $query->closeCursor();
    $uid = $row["UserID"];

    // Select sp and exec
    $sql = "CALL insert_to_belongsto(:uid, :cid)";
    $params = [":uid" => $uid, ":cid" => $cid];
    $query = $database->executeQuery($sql, $params);

    if ($query == false){
      $query = null;
      header("Location: ../includes/assign_students.php?query_error2");
      exit();
    }
    $query->closeCursor();
  }

  public static function binary_to_days($binary){
    $daysMap = [
      0 => "Monday",
      1 => "Tuesday",
      2 => "Wednesday",
      3 => "Thursday",
      4 => "Friday",
      5 => "Saturday",
      6 => "Sunday",
    ];

    $week = $binary;

    for($i = 0; $i < strlen($week); $i++){
      if ($week[$i] == "1"){
        $week_day1 = $daysMap[$i];
        break;
      }
    }

    for($i = strlen($week) - 1; $i >= 0; $i--){
      if ($week[$i] == "1"){
        $week_day2 = $daysMap[$i];
        break;
      }
    }
    return [$week_day1, $week_day2];
  }

  // Function to display class details
  public function display_class() {
    $week = _Class::binary_to_days($this->week);
    $week_day1 = $week[0];
    $week_day2 = $week[1];

    $time1 = substr($this->day1, 0, 4) . "-" . substr($this->day1, 4, 8);
    $time2 = substr($this->day2, 0, 4) . "-" . substr($this->day2, 4, 8);

    echo "Name: $this->name<br>";
    echo "School Year: $this->school_year<br>";
    echo "Group: $this->code<br>";
    echo "Available seats: $this->available_seats<br>";
    echo "First day: $week_day1<br>";
    echo "Time: $time1<br>";
    echo "Second day: $week_day2<br>";
    echo "Time: $time2<br>";
    ($this->next_years == 1) ? (print("Next year's schedule<br>")) : (print("Current year's class<br>"));

    /*
    if (!empty($this->teacher)) {
      echo "Teacher: {$this->teacher->getFullName()}<br>";
    }

    if (!empty($this->students)) {
      echo "Students:\n";
      foreach ($this->students as $student) {
        echo "- {$student->getFullName()}<br>";
      }
    }
    */
  }
}
?>
