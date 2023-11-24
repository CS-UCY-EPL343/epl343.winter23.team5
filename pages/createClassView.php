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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editClass.css">
    <title>Create class</title>
</head>



<body>
    <header>
        <!-- Logo of the institution -->
        <h2 class="logo" style="color: #FFFFFF;">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
        <!-- Navigation section -->
        <nav class="navigation">
            <a href="adminView.php">Admin Page</a>
            <a href="../index.html">Logout</a>
        </nav>
    </header>
    <div class="demo-page">
        <main class="demo-page-content">
            <fieldset class="nice-form-group">
                <form action="../includes/new_class.php" method="POST">
                    <div class="nice-form-group">
                        <label for="name" style="font-weight: bold;">Class Name:</label>
                        <select id="name" name="name" required>
                            <option value="C">Chemistry</option>
                            <option value="P">Physics</option>
                            <option value="M">Math</option>
                        </select><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="school_year" style="font-weight: bold;">School Year:</label>
                        <select id="school_year" name="school_year" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="code" style="font-weight: bold;">Group:</label>
                        <input type="text" id="code" name="code" required><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="available_seats" style="font-weight: bold;">Available seats:</label>
                        <input type="number" id="available_seats" name="available_seats" required><br>
                        <br>
                    </div>

                    <div class="nice-form-group">
                        <label for="First day" style="font-weight: bold;">First day:</label>
                        <select id="first_day" name="first_day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="from1" style="font-weight: bold;">From:</label>
                        <input type="time" id="from1" name="from1" required><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="until1" style="font-weight: bold;">Until:</label>
                        <input type="time" id="until1" name="until1" required><br>
                    </div>

             

                    <div class="nice-form-group">
                        <label for="Second day" style="font-weight: bold;">Second day:</label>
                        <select id="second_day" name="second_day" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="from2" style="font-weight: bold;">From:</label>
                        <input type="time" id="from2" name="from2" required><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="until2" style="font-weight: bold;">Until:</label>
                        <input type="time" id="until2" name="until2" required><br>
                    </div>

                    <div class="nice-form-group">
                        <label for="next_years" style="font-weight: bold;">Next year's schedule:</label>
                        <input type="checkbox" id="next_years" name="next_years" class="switch"><br>
                    </div>

                    <br>
                    <input type="submit" name="create_class" ><br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </form>
            </fieldset>
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
                        <div class="Details"><a
                                href="https://www.facebook.com/idiotikofrontistirioDimitrisEllinas">Idiotiko
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