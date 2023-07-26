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
        <link rel="stylesheet" href="../stylesheets/redirects.css">
        <title><?php echo($title)?></title>
        <link rel="icon" type="image/png" href="resources/images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="/resources/images/favicon-16x16.png" sizes="16x16" />
    </head>
    <body>
        <div class="login-main">
            <div class="login-body">
                <div class="login-info">   
                    <h1 class="login-title">Sorry, we couldn't find that page!</h1>
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