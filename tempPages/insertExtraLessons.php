<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="../css/insertExtraLessons.css">
    <title>insertExtraLessons Page</title>
</head>

<body>
    <!-- Header section -->
    <header>
        <!-- Logo of the institution -->
        <h2 class="logo">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
        <!-- Navigation section -->
        <nav class="navigation">
            <a href="../pages/teacherView.php">Teacher Page</a>
            <a href="../index.html">Logout</a>
        </nav>
    </header>

    <main>

        <form action="../classes/extraLesson.php" method="POST">

            <label for="class number">Class number:</label>
            <input type="number" id="class number" name="class" required><br>

            <label for="Date">Date:</label>
            <input type="date" id="Date" name="date"><br>

            <label for="startTime">Start Time:</label>
            <input type="time" id="startTime" name="timeFrom" required><br>

            <label for="endTime">End Time:</label>
            <input type="time" id="endTime" name="timeTo" required><br>

            <input type="submit" name="submit">


        </form>

        
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            $_SESSION['message'] = '';
        }

        echo "<h1>Your Classes Are:</h1>";

        include '../classes/user.php';
        include '../classes/class.php';
        $serialized = $_SESSION['user'];
        $retrievedUser = unserialize($serialized);


        $database = new Dbh();
        $sql = "CALL find_teaching_classes(:username)";
        $params = [':username' => $retrievedUser->getUsername()];

        $sqlResult = $database->executeQuery($sql, $params);
        if ($sqlResult == false) {
            $sqlResult = null;
            header("location: extraLessonView.php?query_error");
            exit();
        }
        $result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['classes'] = $result;

        $i = 1;
        foreach ($result as $row) {
            echo "Class: $i<br>";
            $class_instance = new _Class(
                $row["CName"],
                $row["SchoolYear"],
                $row["CNumber"],
                $row["AvailableSeats"],
                $row["CDays"],
                $row["TimeForFirstDay"],
                $row["TimeForSecondDay"],
                $row["NextYears"],
                $row["CID"]
            );
            $class_instance->display_class();
            echo "<br>";
            $i++;
        }

        $sqlResult->closeCursor();


        ?>
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
