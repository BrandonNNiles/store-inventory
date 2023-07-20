<?php
    session_start();
    if(!$_SESSION['auth']){
        header("location:login.php"); //redirect unauthed users
        exit();
    }

    require __DIR__ . '/db.php';

    $perms = get_value($_SESSION["username"], "permission");

    if($perms < 2){
        echo("Invalid permissions to see this page");
        exit();
    }
    $title = "User Creation";
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/login.css">
        <title><?php echo($title)?></title>
    </head>
    <body>
        <p>User Creation Screen</p>
    </body>
       
</html>