<?php
//including css
include 'site_css.php';
//starting the session
session_start();

if(empty($_SESSION['Username']))
{
    header("Location: login.php");
}

//connecting to the database
require_once "assignmentdb.php";

//get required information to perform query to add record to reservedbooks table
$id = $_GET['id'];
$u = $_SESSION['Username'];
$d = date("Y\-m\-d");

//update reserved field of book to show it is now reserved
$sql = "UPDATE books SET Reserved = 'Y' WHERE ISBN = '$id'";

$conn->query($sql);

//enter book into reservedbooks table
$sql2 = "INSERT INTO reservedbooks VALUES ('$id', '$u', '$d');";

$conn->query($sql2);

//close connection after use
$conn->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Library Service</title>
    </head>

<body>
    <div class="main">
        <header>
            <h1>Library Service</h1>
<?php

//display the username of current logged in user
echo $_SESSION["Username"] . " is logged in";

?>
        </header>

        <div>
            <h2>Book successfully reserved</h2>




        </div>

        <table>
            <a href = "search.php">Search Again</a><br>
            <a href = "display_reserved.php">Display Your Reserved Books</a><br>
            <a href = "logout.php">Logout</a><br>
        </table>

        <footer>Site by Oluwamayowa Adelaja(C20376476) &copy;2021</footer>
    </div>
</body>

</html>