<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <form action="../includes/signup.inc.php" method="POST">
        Fname: <input type="text" name="fname" require><br>
        Lname: <input type="text" name="lname" require><br>
        Phone: <input type="text" name="phone" require><br>
        Passowrd: <input type="password" name="pwd" require><br>
        Confirm Password: <input type="password" name="pwdConf" require><br>
        Key: <input type="password" name="key"><br>
        <input type="submit" name="submit" value="register">
    </form>
</body>

</html>
