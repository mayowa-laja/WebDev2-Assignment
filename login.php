<?php
//including css
include 'site_css.php';
//starting the session
session_start();

//connecting to the database
require_once "assignmentdb.php";

//if username and password field are not empty
if (!empty($_POST['Username']) && !empty($_POST['Password']) )
{
    $u = $conn->real_escape_string($_POST['Username']);
    $p = $conn->real_escape_string($_POST['Password']);

    $sql = "SELECT username FROM users WHERE username = '$u'";

    $result = $conn->query($sql);

    //if result comes bac with 0 rows the username does not exist
    if(($result->num_rows) <= 0)
    {
        $_SESSION['error'] = 'Username does not exist';
        header("Location: login.php");
        exit();
    }

    $sql1 = "SELECT Password FROM users WHERE Username = '$u'";

    $result1 = $conn->query($sql1);

    $result2 = $result1->fetch_assoc();

    //if passoword inputted by the user matches password in database redirect them to next page, else show error message
    if($p == $result2["Password"])
    {
        $_SESSION["Username"] = $u;
        header("Location: search.php");
        exit();
    }
    else
    {
        $_SESSION['error'] = 'Incorrect password';
        header("Location: login.php");
        exit();
    }
}
elseif(count($_POST) > 0)
{
    $_SESSION['error'] = 'Missing required information';
    header("Location: login.php");
    exit();
}

//close connection when finished
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
        </header>
        <div>
            <h2>Login</h2>

<?php

//if an error message was placed in the variable, display it and then empty the variable
if ( isset($_SESSION['error']) ) 
{
    echo('<p style="color:red">Error:'. $_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}

?>
            
            <form method = "post">
                <p>Username:
                    <input type="text" name="Username">
                </p>

                <p>Passsword:
                    <input type="password" name="Password">
                </p>
                <input class="button" type="submit" value="Login"/>
            </form>
        </div>

        <table>
            <a href = "register.php">Register</a><br>
        </table>

        <footer>Site by Oluwamayowa Adelaja(C20376476) &copy;2021</footer>
    </div>
</body>

</html>