<?php
//session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="../css/header_footer.css" />
  <title>Schedule Template | CodyHouse</title>
</head>
<body style="background-color: #f3f0e7 ;">
<header>
        <!-- Logo of the institution -->
        <h2 class="logo" style="color: #FFFFFF;">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
        <!-- Navigation section -->
        <nav class="navigation">
    
            <a href="../index.html">Logout</a>
        </nav>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  
    <h1 class="text-xl" style="margin-left: 40%;">Next Year's Schedule</h1>
  

    <form action="" method="POST" style="margin-left: 290px;">
      <label for="school_year">School Year:</label>
      <select id="school_year" name="school_year">
        <option value="1">First Gymnasium</option>
        <option value="2">Second Gymnasium</option>
        <option value="3">Third Gymnasium</option>
        <option value="4">First Lyceum</option>
        <option value="5">Second Lyceum</option>
        <option value="6">Third Lyceum</option>
      </select>
    <input type="submit" name="submit" value="submit">
    </form>

  <div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
      <ul>
        <li><span>08:00</span></li>
        <li><span>08:30</span></li>
        <li><span>09:00</span></li>
        <li><span>09:30</span></li>
        <li><span>10:00</span></li>
        <li><span>10:30</span></li>
        <li><span>11:00</span></li>
        <li><span>11:30</span></li>
        <li><span>12:00</span></li>
        <li><span>12:30</span></li>
        <li><span>13:00</span></li>
        <li><span>13:30</span></li>
        <li><span>14:00</span></li>
        <li><span>14:30</span></li>
        <li><span>15:00</span></li>
        <li><span>15:30</span></li>
        <li><span>16:00</span></li>
        <li><span>16:30</span></li>
        <li><span>17:00</span></li>
        <li><span>17:30</span></li>
        <li><span>18:00</span></li>
        <li><span>18:30</span></li>
        <li><span>19:00</span></li>
        <li><span>19:30</span></li>
        <li><span>20:00</span></li>
        <li><span>20:30</span></li>
        <li><span>21:00</span></li>
        <li><span>21:30</span></li>
        <li><span>22:00</span></li>
      </ul>
    </div> <!-- .cd-schedule__timeline -->


<?php
if (isset($_POST["submit"])){
  $school_year = $_POST["school_year"];
  require_once "../classes/DatabaseHandler.php";
  require_once "../classes/class.php";


  $database = new Dbh();
  $sql = "CALL fetch_next_years(:school_year)";
  $params = [":school_year" => $school_year];

  $query = $database->executeQuery($sql, $params);
  if ($query == false){
    $query = null;
    header("Location: schedule.php?query_error");
    exit();
  }

  $rows = $query->fetchALL(PDO::FETCH_ASSOC);

  class lesson{
    public $cname;
    public $from;
    public $until;
    public $color;

    public function __construct($cname, $from, $until){
      switch ($cname[0]) {
      case 'C':
        $this->cname = "Chemistry".$cname[1];
        $this->color = "event-1";
        break;
      case 'M':
        $this->cname = "Math".$cname[1];
        $this->color = "event-4";
        break;
      case 'P':
        $this->cname = "Physics".$cname[1];
        $this->color = "event-2";
        break;
      }
      $this->from  = $from;
      $this->until = $until;
    }
  }

$daysMap = [
  "Monday"    => 0,
  "Tuesday"   => 1,
  "Wednesday" => 2,
  "Thursday"  => 3,
  "Friday"    => 4,
  "Saturday"  => 5,
  "Sunday"    => 6,
];

$week['Monday']    = array();
$week['Tuesday']   = array();
$week['Wednesday'] = array();
$week['Thursday']  = array();
$week['Friday']    = array();
$week['Saturday']  = array();
$week['Sunday']    = array();

foreach ($rows as $row){
  $cname = $row["CName"] . $row["CNumber"];
  $days = _Class::binary_to_days($row["CDays"]);

  $time1_from  = substr($row["TimeForFirstDay"], 0, 4);
  $time1_until = substr($row["TimeForFirstDay"], 4, 8);

  $time2_from  = substr($row["TimeForSecondDay"], 0, 4);
  $time2_until = substr($row["TimeForSecondDay"], 4, 8);

  $obj1 = new lesson($cname, $time1_from, $time1_until);
  $obj2 = new lesson($cname, $time2_from, $time2_until);
  $week[$days[0]][] = $obj1;
  $week[$days[1]][] = $obj2;
}
$query->closeCursor();
}
?>

    <div class="cd-schedule__events">
      <ul>
        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Monday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Monday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Tuesday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Tuesday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Wednesday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Wednesday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Thursday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Thursday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Friday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Friday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Saturday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Saturday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>

        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span>Sunday</span></div>

          <ul>
            <?php
            if(isset($_POST["school_year"])){
              foreach($week["Sunday"] as $obj){
                $from = substr($obj->from, 0, 2) . ":" . substr($obj->from, 2);
                $until = substr($obj->until, 0, 2) . ":" . substr($obj->until, 2);
                echo "<li class=cd-schedule__event>";
                echo "<a data-start=$from data-end=$until data-event=$obj->color>";
                echo "<em class=cd-schedule__name>$obj->cname</em>";
                echo "</a>";
                echo "</li>";
              }
            }
            ?>
          </ul>
        </li>
      </ul>
    </div>

    <div class="cd-schedule-modal">
      <header class="cd-schedule-modal__header">
        <div class="cd-schedule-modal__content">
          <span class="cd-schedule-modal__date"></span>
          <h3 class="cd-schedule-modal__name"></h3>
        </div>

        <div class="cd-schedule-modal__header-bg"></div>
      </header>

      <div class="cd-schedule-modal__body">
        <div class="cd-schedule-modal__event-info"></div>
        <div class="cd-schedule-modal__body-bg"></div>
      </div>

      <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
    </div>

    <div class="cd-schedule__cover-layer"></div>
  </div> <!-- .cd-schedule -->

  <script src="assets/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
  <script src="assets/js/main.js"></script>
</body>


</html>
