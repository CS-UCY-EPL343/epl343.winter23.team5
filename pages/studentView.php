<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] == "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Page</title>
    <link rel="stylesheet" href="../css/index.css" />
  </head>

  <body>

    <!-- This is the User text -->
    <div class="div-1">
      <h1> Student. </h1>
    </div>

    <div class="demo-page">
      <div class="demo-page-navigation">
        <nav>
          <ul>

            <!-- This is the button for extra lessons-->
            <li>
              <a href="#extralessons">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-calendar"
                >
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                  <line x1="16" y1="2" x2="16" y2="6" />
                  <line x1="8" y1="2" x2="8" y2="6" />
                  <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Extra Lessons</a
              >
            </li>

            <!-- This is the button for schedule page -->
            <li>
              <a href="../tempPages/studentpage.php">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-calendar"
                >
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                  <line x1="16" y1="2" x2="16" y2="6" />
                  <line x1="8" y1="2" x2="8" y2="6" />
                  <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
                Schedule </a
              >
            </li>            

            <!-- This is the button for delete account-->
            <li>
              <a href="../includes/delete.inc.php">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-alert-triangle"
                >
                  <path
                    d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"
                  />
                  <line x1="12" y1="9" x2="12" y2="13" />
                  <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                Delete Account</a
              >
            </li>
          </ul>
        </nav>
      </div>

      <main class="demo-page-content">

        <!-- This is the section for information -->
        <section>
          <div class="href-target" id="intro"></div>
          <h1 class="package-name">Notes</h1>
          <p>
            Welcome to our tutoring institution! We're delighted to have you here on our home page. At
            Idiotiko Frontistirio Demetris Ellinas, our commitment is to empower students like you on your educational journey.
            Whether you're seeking support to excel in specific subjects, preparing for exams, or aiming to
            enhance your overall academic performance, we're here to guide and support you every step of
            the way. Explore the wealth of resources, engaging courses, and personalized tutoring services 

          </p>
        </section>

        <!-- This is the section for w/ extra lessons -->
        <section>
          <div class="href-target" id="extralessons"></div>
          <h1>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="feather feather-calendar"
            >
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
              <line x1="16" y1="2" x2="16" y2="6" />
              <line x1="8" y1="2" x2="8" y2="6" />
              <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            Extra Lessons
          </h1>

          <!-- This section print the extra lessons inside the form -->
          <p>
            <?php
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
                    echo '<p>You do not have any extra lessons!</p>';
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
                        echo "<p>Extra Lesson $i: " . $row['ELDate'] . " $time, $CName, Group " . $row['CNumber'] . "</p><br>";
                        $i++;
                    }
                }
            ?>
            </p>
        </section>        
</html>

