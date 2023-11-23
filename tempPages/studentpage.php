<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Link to external stylesheets and scripts -->
  <link rel="stylesheet" href="../css/studentpage.css">
  <script src="../javascript/studentpage.js"></script>

  <!-- Title of the page -->
  <title>Student Page</title>

  <!-- Script for generating weekly schedule and toggling popup -->
  <script>
    // Function to toggle the popup and change button color
    function togglePopup() {
      const popup = document.getElementById("popup-1");
      const button = document.getElementById("extraLessonBtn");

      // Toggle the popup
      popup.classList.toggle("active");

      // Toggle the button color
      button.classList.toggle("active");
    }

    // Function to generate the weekly schedule
    function generateCalendar() {
      // Data structure to store lessons for each day
      const scheduleData = {
        Monday: [],
        Tuesday: [],
        Wednesday: [],
        Thursday: [],
        Friday: [],
        Saturday: [],
        Sunday: []
      };

      // Get the table body element
      const calendarBody = document.getElementById('calendarBody');
      calendarBody.innerHTML = ''; // Clear the existing content

      // Define time slots for the day
      const timeSlots = ['8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM'];

      // Iterate over each time slot
      for (const timeSlot of timeSlots) {
        const row = document.createElement('tr'); // Create a new row for each time slot

        // Add time column to the row
        const timeColumn = document.createElement('td');
        timeColumn.textContent = timeSlot;
        row.appendChild(timeColumn);

        // Add lessons for each day to the row
        for (const day in scheduleData) {
          const lessons = scheduleData[day];
          const lessonColumn = document.createElement('td');

          // Check if there is a lesson for the current day and time
          const lesson = lessons.find(lesson => lesson.includes(timeSlot));
          lessonColumn.textContent = lesson || ''; // If there is a lesson, display it; otherwise, display an empty string

          row.appendChild(lessonColumn);
        }

        // Append the row to the table body
        calendarBody.appendChild(row);
      }
    }

    // Execute the generateCalendar function when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
      generateCalendar();
    });
  </script>
</head>

<body>
  <!-- Header section -->
  <header>
    <!-- Logo of the institution -->
    <h2 class="logo">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
    <!-- Navigation section -->
    <nav class="navigation">
      <a href="studentpage.html">Student Page</a>
      <a href="../index.html">Logout</a>
    </nav>
  </header>

  <!-- Main content section -->
  <main>
    <!-- Weekly schedule section -->
    <div class="weekly-schedule">
      <h2>Weekly Schedule</h2>
      <!-- Table to display the weekly schedule -->
      <table id="calendarTable">
        <thead>
          <!-- Table header with days of the week -->
          <tr>
            <th>Time</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
          </tr>
        </thead>
        <!-- Table body to be populated by the script -->
        <tbody id="calendarBody">

        </tbody>
      </table>
    </div>

    <!-- Popup for extra lessons -->
    <div class="popup" id="popup-1">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-btn" onclick="togglePopup()">&times;</div>
        <h1>Extra Lessons</h1><br>
        <?php
        session_start();




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
      </div>
    </div>

    <!-- Button to toggle the extra lessons popup -->
    <button id="extraLessonBtn" onclick="togglePopup()" onmouseover="changeButtonColor()" onmouseout="restoreButtonColor()">Extra lessons</button>
  </main>

  <footer id="main-footer">
    <div class="footer-container">
        <div id="footer-widgets" class="clearfix">
            <div class="footer-widget">
                <div id="Address">
                    <h4 class="title">Διεύθυνση</h4>
                    <div class="Details">
                        Καραβά 4 & Κερύνειας 93
                        <br>
                        Τ.Κ. 2115, Λευκωσία
                        <br>
                        Κύπρος
                    </div>
                </div>
            </div>
            <div class="footer-widget">
                <div id="Telephone">
                    <h4 class="title">Τηλέφωνο</h4>
                    <div class="Details">+357 99865685</div>
                </div>
            </div>
            <div class="footer-widget">
                <div id="Email">
                    <h4 class="title">Ηλεκτρονικό Ταχυδρομείο</h4>
                    <div class="Details">katysp81@hotmail.com</div>
                </div>
            </div>
            <div class="footer-widget">
                <div id="Facebook">
                    <h4 class="title">Facebook Page</h4>
                    <div class="Details"><a href="https://www.facebook.com/idiotikofrontistirioDimitrisEllinas">Idiotiko Frontistirio D.Ellinas </a></div>
                </div>

            </div>
        </div>
        <img src="https://scontent.fnic2-2.fna.fbcdn.net/v/t39.30808-6/305064635_488074959992715_3372216840304727567_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=5f2048&_nc_ohc=y0S9bs8t0fEAX9psX15&_nc_ht=scontent.fnic2-2.fna&oh=00_AfDxJvCQFMdW_jrwyZHHtUX2FqNlfLpjcC0UTe2dUV62PQ&oe=65615F29">
    </div>
</footer>

</body>

</html>
