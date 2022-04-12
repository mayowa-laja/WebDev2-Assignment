<?php
//start the session
session_start();

if(empty($_SESSION['Username']))
{
    header("Location: login.php");
}

//destroy the session
session_destroy();

//redirect to login page
header("Location: login.php");

?>