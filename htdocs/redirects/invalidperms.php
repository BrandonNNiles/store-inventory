<?php
    //Configurables
    $title = "Invalid Permissions"; //title of the page
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../stylesheets/login.css">
        <title><?php echo($title)?></title>
        <link rel="icon" type="image/png" href="resources/images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="/resources/images/favicon-16x16.png" sizes="16x16" />
    </head>
    <body>   
        <p>You have no permissions to view that page.</p>
        <br>
        <a href="javascript:history.back()">Go Back</a>
    </body>
</html>