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

//results allowed per page
$results_per_page = 5;

//if search type selected was Title search continue
if($_SESSION['search_type'] == 'Title')
{
    $t = $_SESSION['Title'];
    $sql = "SELECT * FROM books WHERE BookTitle like '%$t%'";

    $result = $conn->query($sql);

    //get number of results to be displayed
    $number_of_result = mysqli_num_rows($result);
    //get number of pages required
    $number_of_page = ceil($number_of_result/$results_per_page);

    //get current page no.
    if (!isset ($_GET['page']) ) 
    {  
        $page = 1;  
    } 
    else 
    {  
        $page = $_GET['page'];  
    }  

    //get the index of the first result needed in this page no.
    $page_first_result = ($page-1) * $results_per_page;

    $sql = "SELECT * FROM books WHERE BookTitle like '%$t%' LIMIT " . $page_first_result . ',' . $results_per_page;
    $result = $conn->query($sql);
    
}
elseif($_SESSION['search_type'] == 'Author')//if search type selected was Author search continue
{
    $a = $conn->real_escape_string($_SESSION['Author']);
    $sql = "SELECT * FROM books WHERE Author like '%$a%'";

    $result = $conn->query($sql);

    //get number of results to be displayed
    $number_of_result = mysqli_num_rows($result);
    //get number of pages required
    $number_of_page = ceil($number_of_result/$results_per_page);

    //get current page no.
    if (!isset ($_GET['page']) ) 
    {  
        $page = 1;  
    } 
    else 
    {  
        $page = $_GET['page'];  
    }  

    //get the index of the first result needed in this page no.
    $page_first_result = ($page-1) * $results_per_page;

    $sql = "SELECT * FROM books WHERE Author like '%$a%' LIMIT " . $page_first_result . ',' . $results_per_page;
    $result = $conn->query($sql);
    
}
elseif($_SESSION['search_type'] == 'Both')//if search type selected was Both search continue
{
    $t = $_SESSION['Title'];
    $a = $_SESSION['Author'];
    $sql = "SELECT * FROM books WHERE BookTitle like '%$t%' AND Author like '%$a%'";

    $result = $conn->query($sql);

    //get number of results to be displayed
    $number_of_result = mysqli_num_rows($result);
    //get number of pages required
    $number_of_page = ceil($number_of_result/$results_per_page);

    //get current page no.
    if (!isset ($_GET['page']) ) 
    {  
        $page = 1;  
    } 
    else 
    {  
        $page = $_GET['page'];  
    }  

    //get the index of the first result needed in this page no.
    $page_first_result = ($page-1) * $results_per_page;

    $sql = "SELECT * FROM books WHERE BookTitle like '%$t%' LIMIT " . $page_first_result . ',' . $results_per_page;
    $result = $conn->query($sql);
    
}
elseif($_SESSION['search_type'] == 'Category')//if search type selected was Category search continue
{
    $c = $_SESSION['Category'];
    $sql = "SELECT * FROM books WHERE Category = $c";

    $result = $conn->query($sql);

    //get number of results to be displayed
    $number_of_result = mysqli_num_rows($result);
    //get number of pages required
    $number_of_page = ceil($number_of_result/$results_per_page);

    //get current page no.
    if (!isset ($_GET['page']) ) 
    {  
        $page = 1;  
    } 
    else 
    {  
        $page = $_GET['page'];  
    }  

    //get the index of the first result needed in this page no.
    $page_first_result = ($page-1) * $results_per_page;

    $sql = "SELECT * FROM books WHERE BookTitle like '%$t%' LIMIT " . $page_first_result . ',' . $results_per_page;
    $result = $conn->query($sql);
    
}

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
            <h2>Results of the search</h2>

<?php

//display results of the search in a table
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
        //if book is reserved display that it is already reserved
        if($row["Reserved"] == 'Y')
        {
            echo("Already Reserved");
        }
        else//if book is not reserved put link to reserve it
        {
            echo('<a href="reserve.php?id='.htmlentities($row["ISBN"]).'">Reserve</a> ');
        }
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";

    //keep track and update page number
    for($page = 1; $page<= $number_of_page; $page++) 
    {  
        echo '<a href = "display.php?page=' . $page . '">' . $page . ' </a>';  
    }  

}
else//error message for if no books are found in the search
{
    echo "<p style='color:red; font-size:30px;'> The search yielded 0 results</p>";
}

?>


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