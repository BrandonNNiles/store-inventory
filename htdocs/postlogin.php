<?php
    session_start();
    if(!$_SESSION['auth']){
        header("location:login.php"); //redirect unauthed users
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/login.css">
    </head>
    <body>
        <p>Weclome <?php
        echo $_SESSION["username"];
        ?>
    !
    </p>
        <br>
        <a href="logout.php">Log Out</a>
        <a href="createuser.php">User Creation</a>
    </body>
</html>