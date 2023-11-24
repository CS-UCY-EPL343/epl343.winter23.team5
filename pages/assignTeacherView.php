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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Assign teacher</title>
    <style>
        table td,
        table th {
            vertical-align: middle;
            text-align: right;
            padding: 20px;
        }
    </style>
</head>

<body class="Mybody">
    <header>
        <!-- Logo of the institution -->
        <h2 class="logo" style="color: #FFFFFF;">ΙΔΙΩΤΙΚΟ ΦΡΟΝΤΙΣΤΗΡΙΟ Δ.ΕΛΛΗΝΑΣ</h2>
        <!-- Navigation section -->
        <nav class="navigation">
            
        </nav>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container my-4">

        

        <?php
        // If deletion from databse was successfull.
        if (isset($_SESSION["assign"])) {
            ?>
            <div class="alert alert-success">
                <?php
                echo "Deleted successfully!";
                ?>
            </div>
            <?php
            unset($_SESSION["assign"]);
        }
        ?>

        <h2>Assign tutor to class</h2>

        <table class="table table-bordered" style="border-color: black;">
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

                require_once "../classes/DatabaseHandler.php";
                $database = new Dbh();

                // Select sp and exec
                $sql = "CALL fetch_teachers()";
                $params = [];
                $query = $database->executeQuery($sql, $params);

                if ($query == false) {
                    $query = null;
                    header("Location: ../includes/new_class.php?query_error");
                    exit();
                }


                $rows = $query->fetchALL(PDO::FETCH_ASSOC);
                $i = 1;
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i ?>
                        </td>
                        <td>
                            <?php echo $row['Fname']; ?>
                        </td>
                        <td>
                            <?php echo $row['Lname']; ?>
                        </td>
                        <td>
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
                            <a href="../includes/assign_teacher.php?username=<?php echo $row['username']; ?>"
                                class="btn btn-info">Assign</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
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