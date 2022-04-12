<?php
//including css
include 'site_css.php';
//starting the session
session_start();

//connecting to the database
require_once "assignmentdb.php";

//if all fields were filled in continue
if (!empty($_POST['Username']) && !empty($_POST['Password']) && !empty($_POST['FirstName']) && !empty($_POST['Surname']) && !empty($_POST['AddressLine1']) && !empty($_POST['AddressLine2']) && !empty($_POST['City']) && !empty($_POST['Telephone']) && !empty($_POST['Mobile']))
{
    //if password is not 6 characters or telephone/mobile no. more than 10 digits or telephone/mobile no. contains anything other than digits display error message
    if (strlen($_POST['Password']) != 6 || strlen($_POST['Telephone']) > 10 || strlen($_POST['Mobile']) > 10 || !ctype_digit($_POST['Telephone']) || !ctype_digit($_POST['Mobile']))
    {
        $_SESSION['error'] = 'There has been an input error, please read input instructions carefully and fill in all the fields!';
        header("Location: register.php");
        exit();
    }
    elseif ($_POST['Password'] != $_POST['Passwordc'])//if password confirmation is wrong display error message
    {
        $_SESSION['error'] = 'Password cofirmation different from original password!';
        header("Location: register.php");
        exit();
    }
    
    //convert input to make it sql friendly
    $u = $conn->real_escape_string($_POST['Username']);
    $p = $conn->real_escape_string($_POST['Password']);
    $f = $conn->real_escape_string($_POST['FirstName']);
    $s = $conn->real_escape_string($_POST['Surname']);
    $a1 = $conn->real_escape_string($_POST['AddressLine1']);
    $a2 = $conn->real_escape_string($_POST['AddressLine2']);
    $c = $conn->real_escape_string($_POST['City']);
    $t = $conn->real_escape_string($_POST['Telephone']);
    $m = $conn->real_escape_string($_POST['Mobile']);

    $sql1 = "SELECT username FROM users WHERE username = '$u'";

    $result = $conn->query($sql1);

    //if query comes back with a row that means username already exists and cannot be used
    if(($result->num_rows) > 0)
    {
        $_SESSION['error'] = 'Username already exists';
        header("Location: register.php");
        exit();
    }
    
    $sql = "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile) VALUES ('$u', '$p', '$f', '$s', '$a1', '$a2', '$c', '$t', '$m')";

    $conn->query($sql);

    //after user is registered redirect to login page
    header("Location: login.php");
    exit();

}
elseif(count($_POST) > 0)
{
    $_SESSION['error'] = 'Missing required information';
    header("Location: register.php");
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
        </header>

        <div>
            <h2>Register as a new user</h2>

<?php

//if an error message was placed in the variable, display it and then empty the variable
if ( isset($_SESSION['error']) ) 
{
    echo('<p style="color:red">Error:'. $_SESSION['error']."</p>\n");
    unset($_SESSION['error']);
}

?>

            <form action = "register.php" method = "post">
                <p>Username:<br>
                    <input type="text" name="Username">
                </p>

                <p>Passsword(Must be 6 characters in length):<br>
                    <input type="text" name="Password">
                </p>

                <p>Passsword confirmation:<br>
                    <input type="text" name="Passwordc">
                </p>

                <p>Firstname:<br>
                    <input type="text" name="FirstName">
                </p>

                <p>Surname:<br>
                    <input type="text" name="Surname">
                </p>

                <p>AddressLine1:<br>
                    <input type="text" name="AddressLine1">
                </p>

                <p>AddressLine2:<br>
                    <input type="text" name="AddressLine2">
                </p>

                <p>City:<br>
                    <input type="text" name="City">
                </p>

                <p>Telephone(Must be 10 numbers or less and must consist of only digits):<br>
                    <input type="text" name="Telephone">
                </p>

                <p>Mobile(Must be 10 numbers or less and must consist of only digits):<br>
                    <input type="text" name="Mobile">
                </p>
                <input class="button" type="submit" value="Register"/>
            </form>
        </div>

        <table>
            <a href = "login.php">Login</a><br>
        </table>

        <footer>Site by Oluwamayowa Adelaja(C20376476) &copy;2021</footer>
    </div>
</body>

</html>