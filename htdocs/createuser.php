<?php
    //Configurables
    $title = "User Creation"; //title of the page
    $require_auth = true; //whether or not the user needs to be logged in to see this page
    $perm_level = 2; //the user's permision level to see the page (requires require_auth = true)

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
        <p>User Creation Screen</p>
    </body>
       
</html>