<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Admin") {
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Page</title>
  <link rel="stylesheet" href="../css/index.css" />
  <link rel="stylesheet" href="../css/header_footer.css" />
  
  <style>
    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 50vh;
      margin: 0;
    }

    .div-1 {
      text-align: center;
    }

    h1 {
      margin-top: 0; /* Remove default margin for h1 */
    }
  </style>
</head>
<header>
    <!-- Logo of the institution -->
    <h2 class="logo">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
    <!-- Navigation section -->
    <nav class="navigation">
      <a href="../pages/adminView.php">Admin Page</a>
      <a href="../index.html">Logout</a><br>
    </nav>
  </header>

<body>
  
  <div class="div-1">
  <br>
    <h1> Admin. </h1>
  </div>
  <div class="demo-page">
    <div class="demo-page-navigation">
      <nav>
        <ul>
          <li>
            <a href="../pages/deleteUserView.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-tool">
                <path
                  d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
              </svg>
              Remove Users</a>
          </li>
          <li>
            <a href="../pages/enrollView2.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Enroll Students</a>
          </li>
          <li>
            <!-- <a href="../pages/deleteClassView.php"> -->
            <a href="../pages/deleteClassView2.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-feather">
                <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z" />
                <line x1="16" y1="8" x2="2" y2="22" />
                <line x1="17.5" y1="15" x2="9" y2="15" />
              </svg>
              Delete Classes</a>
          </li>
          <li>
            <a href="../pages/createClassView.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-calendar">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                <line x1="16" y1="2" x2="16" y2="6" />
                <line x1="8" y1="2" x2="8" y2="6" />
                <line x1="3" y1="10" x2="21" y2="10" />
              </svg>
              Create Class</a>
          </li>
        </ul>
      </nav>
    </div>

    <main class="demo-page-content">
      <section>
        <div class="href-target" id="intro"></div>
        <h1 class="package-name">Notes</h1>
        <p>
          This is the <strong>admin</strong> page. You can perform
          a number of different tasks to manage the Tutoring Institution.
          The task bar provided on the left will redirect you to the
          appropriate location to perform the desired functionality.
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