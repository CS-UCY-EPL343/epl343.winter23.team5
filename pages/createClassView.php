<?php
session_start();
if (!isset($_SESSION['type']) || $_SESSION['type'] !== "Admin"){
  header("Location: ../index.php?error");
  exit("Not supposed to be here...");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create class</title>
    <style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 400px;
}

h1 {
    text-align: center;
    color: #333333;
}

label {
    display: block;
    margin-top: 10px;
    color: #333333;
}

select,
input,
checkbox {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    box-sizing: border-box;
    border: 1px solid #cccccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #ffffff;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}
</style>
</head>

<h1>Create class</h1>

<body>

<form action="../includes/new_class.php" method="post">
    <label for="name">Class Name:</label>
<select id="name" name="name" required>
    <option value="C">Chemistry</option>
    <option value="P">Physics</option>
    <option value="M">Math</option>
</select><br>

    <label for="school_year">School Year:</label>
<select id="school_year" name="school_year" required>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
</select><br>

    <label for="code">Group:</label>
    <input type="text" id="code" name="code" required><br>

    <label for="available_seats">Available seats:</label>
    <input type="number" id="available_seats" name="available_seats" required><br>
    <br>
    <label for="First day">First day:</label>
<select id="first_day" name="first_day" required>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
</select><br>

    <label for="from1">From:</label>
    <input type="time" id="from1" name="from1" required><br>

    <label for="until1">Until:</label>
    <input type="time" id="until1" name="until1" required><br>

    <br>

    <label for="Second day">Second day:</label>
<select id="second_day" name="second_day" required>
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
</select><br>

    <label for="from2">From:</label>
    <input type="time" id="from2" name="from2" required><br>

    <label for="until2">Until:</label>
    <input type="time" id="until2" name="until2" required><br>

    <label for="next_years">Next year's schedule:</label>
    <input type="checkbox" id="next_years" name="next_years"><br>

    <input type="submit" name="create_class" value="Create Class">
</form>

</body>
</html>
