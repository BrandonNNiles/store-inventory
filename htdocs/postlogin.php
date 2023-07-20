<?php
    //Configurables
    $title = "User Creation"; //title of the page
    $require_auth = true; //whether or not the user needs to be logged in to see this page
    $perm_level = 0; //the user's permision level to see the page (requires require_auth = true)

    require __DIR__ . '/modules/authmanager.php';
    view_redirect($require_auth, $perm_level);
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/login.css">
        <title><?php echo($title)?></title>
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