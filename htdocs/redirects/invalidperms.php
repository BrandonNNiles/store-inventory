<?php
    //Configurables
    $title = "Invalid Permissions"; //title of the page
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../stylesheets/login.css">
        <link rel="stylesheet" href="../stylesheets/redirects.css">
        <title><?php echo($title)?></title>
        <link rel="icon" type="image/png" href="resources/images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="/resources/images/favicon-16x16.png" sizes="16x16" />
    </head>
    <body>
        <div class="login-main">
            <div class="login-body">
                <div class="login-info">   
                    <h1 class="login-title">You have no permissions to view that page.</h1>
                    <br>
                </div>
                <div class="submit-cont">
                    <div class ="container">
                        <a href="javascript:history.back()" class = "back-a">Go Back</a>
                    </div>  
                </div>
            </div>
        </div>
    </body>
</html>