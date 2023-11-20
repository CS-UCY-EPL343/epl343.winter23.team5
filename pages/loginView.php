<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="../includes/login.inc.php" method="POST">
        Username: <input type="text" name="username" require><br>
        Passowrd: <input type="password" name="pwd" require><br>
        <input type="submit" name="submit" value="login">
    </form>

</body>

</html>
