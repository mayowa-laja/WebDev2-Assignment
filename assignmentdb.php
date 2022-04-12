<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "assignmentdb";

//connecting to the database
$conn = new mysqli($servername, $username, $password, $database);

//if connnection fails print out the error message
if($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}

?>