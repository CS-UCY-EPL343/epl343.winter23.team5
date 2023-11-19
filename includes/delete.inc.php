<?php
// This is the file our data is sent in order to delete account.


//Check if we accesed the page using the button not by URL
if(isset($_POST["delete"]))
{
    // Instancite SignupContr class
    include "../classes/DatabaseHandler.php";
    include "../classes/User.php";

    session_start();

    $zipUser = $_SESSION['user'];
    $user = unserialize($zipUser);

    $user -> deleteAccount();

}


?>