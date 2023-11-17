<?php
// This is the file our data is sent in order to sign up.


//Check if we accesed the page using the button not by URL
if(isset($_POST["submit"]))
{
    // Grab the information
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];
    $pwd = $_POST["pwd"];
    $pwdConf = $_POST["pwdConf"];
    $key = $_POST["key"];

    // Instancite SignupContr class
    include "../classes/DatabaseHandler.php";
    include "../classes/User.php";

    // If user put this key then Useer type is teacher
    if($key == 'demetrisellinas'){
        $signup = new User($fname, $lname, $pwd, $pwdConf, $phone, $type = 1,$username=null);
    }else{
        $signup = new User($fname, $lname, $pwd, $pwdConf, $phone, $type = 0 ,$username=null);
    }

    // Running error handlers and user signup
    $signup -> register();

}
?>