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
        $perms = get_value($username, "permission");

        if(password_verify($password, $db_pass)) {
            $_SESSION['auth'] = 'true';
            $_SESSION['username'] = $username;
            $_SESSION["login-fail"] = 0;
            $_SESSION["perms"] = $perms;
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

    //Returns a SQLi connection object with set information
    function sqlconn(){
        //Connection info
        $host = "***";
        $user = "***";
        $pass = "***";
        $db = "***";
        $port = "***";

        $conn = new mysqli($host, $user, $pass, $db, $port);
        if ($conn -> connect_errno){ //check to see if connection failed
            echo("Failed to connect to MySQL: " . $conn -> connect_error);
            exit();
        }
        return $conn;
    }

    //returns a value stored in col_name for a given username
    function get_value($username, $col_name){
        $conn = sqlconn();

        //Prepare and bind query
        $query = $conn->prepare("SELECT * FROM USERS WHERE username = ?");
        $query->bind_param("s", $username);

        //Execute query statement
        $query->execute();

        $result = $query->get_result();

        if($result == false){
            echo("Query failed.");
            exit();
        }

        $row = $result->fetch_assoc();

        if($row == NULL){
            login_failed(); //invalid username
        } elseif($row == false){
            echo("Results failed.");
            exit();
        }

        $value = $row[$col_name];
        //Close connections and querries
        $query->close();
        $conn->close();

        return $value;
    }
?>