<?php
// This is the file our data is sent in order to sign up.


//Check if we accesed the page using the button not by URL
if(isset($_POST["submit"]))
{
    // Grab the information
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    // Instancite SignupContr class
    include "../classes/DatabaseHandler.php";
    include "../classes/User.php";

    $login = new User($fname=null, $lname=null, $pwd, $pwdConf=null, $phone=null, $type = null, $username);

    // Running error handlers and user signup
    $login -> login();
}

?>