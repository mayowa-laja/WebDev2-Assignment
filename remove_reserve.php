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

//get the ISBN of the book from the URL
$id = $_GET['id'];

//update reserved field of book to make it available to be reserved
$sql = "UPDATE books SET Reserved = 'N' WHERE ISBN = '$id'";

$conn->query($sql);

//delete the record from the reservedbooks table
$sql2 = "DELETE FROM reservedbooks WHERE ISBN = '$id'";

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
            <h2>Book successfully removed from reserved books</h2>




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