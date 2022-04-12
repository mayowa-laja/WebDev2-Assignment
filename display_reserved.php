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

//get userame of current user from session variable
$u = $_SESSION['Username'];

//query to display the user's reserved books
$sql = "SELECT * FROM books INNER JOIN reservedbooks ON books.ISBN = reservedbooks.ISBN WHERE reservedbooks.Username = '$u'";

$result = $conn->query($sql);

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
            <h2>Your reserved books</h2>

<?php

//displaying all of the user's reserved books
if ($result->num_rows > 0)
{
    echo "<table class='table1' border='1'>";
    echo "<tr>";
    echo "<th>";
    echo "ISBN";
    echo "</th>";
    echo "<th>";
    echo "BookTitle";
    echo "</th>";
    echo "<th>";
    echo "Author";
    echo "</th>";
    echo "<th>";
    echo "Edition";
    echo "</th>";
    echo "<th>";
    echo "Year";
    echo "</th>";
    echo "<th>";
    echo "Category";
    echo "</th>";
    echo "<th>";
    echo "Reserved";
    echo "</th>";
    echo "<th>";
    echo "Reserve";
    echo "</th>";
    echo "</tr>";

    while($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>";
        echo(htmlentities($row["ISBN"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["BookTitle"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["Author"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["Edition"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["Year"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["Category"]));
        echo "</td>";
        echo "<td>";
        echo(htmlentities($row["Reserved"]));
        echo "</td>";
        echo "<td>";
        //add a link so that the user can remove a book from their reservations
        echo('<a href="remove_reserve.php?id='.htmlentities($row["ISBN"]).'">Remove reservation</a> ');
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

}
else 
{
    echo "0 results";
}

?>


        </div>

        <table>
            <a href = "search.php">Search Again</a><br>
            <a href = "logout.php">Logout</a><br>
        </table>

        <footer>Site by Oluwamayowa Adelaja(C20376476) &copy;2021</footer>
    </div>
</body>

</html>