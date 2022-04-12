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

//get all from category table for use in dropdown menu in from
$sql = "SELECT * FROM category";

$result = $conn->query($sql);

//if search type was selected continue
if (!empty($_POST['search_type']))
{
    //if search type selected was Title search continue
    if($_POST['search_type'] == 'Title')
    {
        //if Category was selected or input detected in author field display error message
        if(!empty($_POST['Category']) || !empty($_POST['Author']))
        {
            $_SESSION['error'] = 'If you are searching by title leave the other fields empty';
            header("Location: search.php");
            exit();
        }
        elseif(empty($_POST['Title']))//if title field is empty display error message
        {
            $_SESSION['error'] = 'You must enter something into the Title field if you are searching by title';
            header("Location: search.php");
            exit();
        }
        //if all is well put information into session variables for later use and redirect user to file to display search results
        $_SESSION['Title'] = $_POST['Title'];
        $_SESSION["search_type"] = $_POST['search_type'];
        header("Location: display.php");
        exit();
    }
    elseif($_POST['search_type'] == 'Author')//if search type selected was Author search continue
    {
        //if Category was selected or input detected in title field display error message
        if(!empty($_POST['Category']) || !empty($_POST['Title']))
        {
            $_SESSION['error'] = 'If you are searching by author leave the other fields empty';
            header("Location: search.php");
            exit();
        }
        elseif(empty($_POST['Author']))//if author field is empty display error message
        {
            $_SESSION['error'] = 'You must enter something into the Author field if you are searching by author';
            header("Location: search.php");
            exit();
        }
        //if all is well put information into session variables for later use and redirect user to file to display search results
        $_SESSION['Author'] = $_POST['Author'];
        $_SESSION["search_type"] = $_POST['search_type'];
        header("Location: display.php");
        exit();
    }
    elseif($_POST['search_type'] == 'Both')//if search type selected was Both search continue
    {
        //if Category was selected display error message
        if(!empty($_POST['Category']))
        {
            $_SESSION['error'] = 'If you are searching by title and author leave the other fields empty';
            header("Location: search.php");
            exit();
        }
        elseif(empty($_POST['Author']) || empty($_POST['Title']))//if author and title fields are empty display error message
        {
            $_SESSION['error'] = 'You must enter an Author and Title';
            header("Location: search.php");
            exit();
        }
        //if all is well put information into session variables for later use and redirect user to file to display search results
        $_SESSION['Title'] = $_POST['Title'];
        $_SESSION['Author'] = $_POST['Author'];
        $_SESSION["search_type"] = $_POST['search_type'];
        header("Location: display.php");
        exit();
    }
    elseif($_POST['search_type'] == 'Category')//if search type selected was Category search continue
    {
        //if title or author fields contain input display error message
        if(!empty($_POST['Title']) || !empty($_POST['Author']))
        {
            $_SESSION['error'] = 'If you are searching by category leave the other fields empty';
            header("Location: search.php");
            exit();
        }
        elseif(empty($_POST['Category']))//if category was not selected display error message
        {
            $_SESSION['error'] = 'You must select an option from the dropdown menu if you are searching by category';
            header("Location: search.php");
            exit();
        }
        //if all is well put information into session variables for later use and redirect user to file to display search results
        $_SESSION['Category'] = $_POST['Category'];
        $_SESSION["search_type"] = $_POST['search_type'];
        header("Location: display.php");
        exit();
    }

}
elseif(count($_POST) > 0)
{
    $_SESSION['error'] = 'Search type not selected';
    header("Location: search.php");
    exit();
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
            <h2>Search for a book</h2>

<?php

//if an error message was placed in the variable, display it and then empty the variable
if ( isset($_SESSION['error']) ) 
{
    echo('<p style="color:red">Error:'. $_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}

?>

            <form method = "post">
                <p>
                    Search for a book:<br>
                </p>

                <p>Title:
                    <input type="text" name="Title">
                </p>

                <p>Author:
                    <input type="text" name="Author">
                </p>

                <p>Category:
                </p>

                <select name = "Category">
                <option disabled selected value> -- select an option -- </option>

<?php
//fetch rows of information from category table, value of option in dropdown menu is the CategoryID and the text displayed is the Category Description
while($row = $result->fetch_assoc()):;

?>

                <option value="<?php echo $row["CategoryID"];?>">
                <?php echo $row["CategoryDescription"];?>
                </option>

<?php
endwhile;
?>


                </select><br>

                <p>Search Type:
                </p>
                <input type="radio" id="title" name="search_type" value="Title">
                <label for="title">Title</label><br>
                <input type="radio" id="author" name="search_type" value="Author">
                <label for="author">Author</label><br>
                <input type="radio" id="both" name="search_type" value="Both">
                <label for="both">Both(Title and Author)</label><br>
                <input type="radio" id="category" name="search_type" value="Category">
                <label for="category">Category</label><br>
                
                <input class="button" type="submit" value="Search"/>
            </form>
        </div>

        <table>
        <a href = "display_reserved.php">Display Your Reserved Books</a><br>
        <a href = "logout.php">Logout</a><br>
        </table>

        <footer>Site by Oluwamayowa Adelaja(C20376476) &copy;2021</footer>
    </div>
</body>

</html>