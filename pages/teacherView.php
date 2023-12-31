<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Teacher") {
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teacher Page</title>
  <link rel="stylesheet" href="../css/index.css" />
  <link rel="stylesheet" href="../css/header_footer.css" />
</head>

<body>

  <!-- This is the User text -->
  <div class="div-1">
    <h1> Teacher. </h1>
  </div>

  <div class="demo-page">
    <div class="demo-page-navigation">
      <nav>
        <ul>

          <!-- This is the button for Editing Classes page -->
          <li>
            <a href="../pages/editClassView2.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-tool">
                <path
                  d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
              </svg>
              Edit Classes</a>
          </li>

          <!-- This is the button for add extra lessons page page -->
          <li>
            <!-- <a href="../pages/extraLessonView.php"> -->
            <a href="../tempPages/insertExtraLessons.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-calendar">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
              </svg>
              Add Extra Lessons </a>
          </li>

          <!-- This is the button for delete account-->
          <li>
            <a href="../includes/delete.inc.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-alert-triangle">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
              </svg>
              Delete Account</a>
          </li>
        </ul>
      </nav>
    </div>

    <main class="demo-page-content">

      <!-- This is the section for information -->
      <section>
        <div class="href-target" id="intro"></div>
        <h1 class="package-name">Welcome:</h1>
        <p>
          This is the <strong>Teacher<strong> page. Here you
              can edit classes etc...
        </p>
      </section>
    </main>
  </div>
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
            <div class="Details"><a href="https://www.facebook.com/idiotikofrontistirioDimitrisEllinas">Idiotiko
                Frontistirio D.Ellinas </a></div>
          </div>

        </div>
      </div>
      <img
        src="https://scontent.fnic2-2.fna.fbcdn.net/v/t39.30808-6/305064635_488074959992715_3372216840304727567_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=5f2048&_nc_ohc=y0S9bs8t0fEAX9psX15&_nc_ht=scontent.fnic2-2.fna&oh=00_AfDxJvCQFMdW_jrwyZHHtUX2FqNlfLpjcC0UTe2dUV62PQ&oe=65615F29">
    </div>
  </footer>
</body>

</html>