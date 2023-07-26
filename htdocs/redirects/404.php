<?php
    //Configurables
    $title = "Page Not Found"; //title of the page
    $require_auth = true; //whether or not the user needs to be logged in to see this page
    $perm_level = 0; //the user's permision level to see the page (requires require_auth = true)

    require dirname(dirname(__FILE__)) . '/modules/authmanager.php';
    view_redirect($require_auth, $perm_level);
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../stylesheets/login.css">
        <title><?php echo($title)?></title>
    </head>
    <body>   
        <p>Sorry, we couldn't find that page!</p>
        <br>
        <a href="javascript:history.back()">Go Back</a>
    </body>
</html>