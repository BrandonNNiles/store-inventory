<?php
    //Configurables
    $title = "Invalid Permissions"; //title of the page
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../stylesheets/login.css">
        <title><?php echo($title)?></title>
    </head>
    <body>   
        <p>You have no permissions to view that page.</p>
        <br>
        <a href="javascript:history.back()">Go Back</a>
    </body>
</html>