<?php
    //Configurables
    $title = "CP476 Log In"; //title of the page
    $postlogin = "postlogin.php"; //postlogin redirection

    //Prevent auth'd users from seeing the login page
    session_start();
    if(array_key_exists("auth", $_SESSION)){
        if($_SESSION["auth"]){
            header("location:$postlogin"); //redirect authed users
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/login.css">
        <title><?php echo($title)?></title>
    </head>
    <body>
        <div class="login-main">
            <div class="login-body">
                <h1 class="login-title">Log In</h1>
                <form method="POST">
                    <div class="login-info">
                        <div class="login-entry-cont">
                            <p class="login-entry-text">Username</p>
                            <input type="text" class="login-entry-input" name="username">
                        </div>
                        <div class="login-entry-cont">
                            <p class="login-entry-text">Password</p>
                            <input type="password" class="login-entry-input" name="password">
                        </div>
                        <div class="login-entry-remember">
                            <input type="checkbox" id="remember-me" name="remember-me">
                            <label for="remember-me">Remember Me</label>
                        </div>
                    </div>
                    <div class="submit-cont">
                        <input type="submit" class="login-submit" value="Sign In">
                        <?php if(array_key_exists("login-fail", $_SESSION)){
                            if($_SESSION["login-fail"] > 0){ ?>
                            <div class="error">Invalid username/password combination.</div>
                        <?php }} ?>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
    require __DIR__ . '/db.php';

    if(!array_key_exists("login-fail", $_SESSION)){ //have we failed to login?
        $_SESSION["login-fail"] = 0;
    } else {
        $_SESSION["login-fail"] = $_SESSION["login-fail"] - 1; //no longer fail after an additonal refresh
    }

    if($_POST){
        //Get user input for username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db_pass = get_value($username, "user_password");
        $firstname = get_value($username, "first_name");
        $lastname = get_value($username, "last_name");

        if(password_verify($password, $db_pass)) {
            $_SESSION['auth'] = 'true';
            $_SESSION['username'] = $username;
            $_SESSION["firstname"] = $firstname;
            $_session["lastname"] = $lastname;
            $_SESSION["login-fail"] = 0;
            header("location:$postlogin");
        } else {
            login_failed(); //invalid password
        }
    }

    function login_failed(){
        $_SESSION["login-fail"] = 2;
        header("Refresh:0");
        exit();
    }
?>