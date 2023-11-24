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
    <title>Students</title>
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
            <a href="adminView.php">Admin Page</a>
            <a href="../index.html">Logout</a>
        </nav>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="container my-4">

        <h1>Student List</h1>


        <?php
        #session_start();
        // If deletion from databse was successfull.
        if (isset($_SESSION["delete"])) {
            ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION["delete"];
                ?>
            </div>
            <?php
            unset($_SESSION["delete"]);
        }
        ?>

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
                //Here we will call show students
                //Connect to database using handler
                require_once "../classes/DatabaseHandler.php";
                $database = new Dbh();

                // Select the stored proc and exexute
                $sql = "CALL get_enrolled()";
                $params = [];
                $sqlResult = $database->executeQuery($sql, $params);
                $result = $sqlResult->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                foreach ($result as $row) {
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
                            <a href="../includes/adminDelete2.inc.php?username=<?php echo $row['username']; ?>"
                                class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php

                    $i = $i + 1;
                }

                // Clear query and close cursor
                $sql = null;
                $sqlResult->closeCursor();

                ?>
            </tbody>
        </table>
    </div>
</body>

</html>