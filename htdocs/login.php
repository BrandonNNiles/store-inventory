<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/login.css">
    </head>
    <body>
        <form method="POST">
            <div class="login-main">
                <div class="login-body">
                    <h1 class="login-title">Log In</h1>
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
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>

<?php
    if($_POST){
        //Connection info
        $host = "***";
        $user = "***";
        $pass = "***";
        $db = "***";
        $port = "***";

        $conn = new mysqli($host, $user, $pass, $db, $port); //establish connection

        if ($conn -> connect_errno){ //check to see if connection failed
            echo("Failed to connect to MySQL: " . $conn -> connect_error);
            exit();
        }

        //prepare query statement
        $query = $conn->prepare("SELECT user_password FROM USERS WHERE username = ?");
        $query->bind_param("s", $username);

        //Get user input for username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        //Execute query statement
        $query->execute();

        $result = $query->get_result();
        //Close statements and connection
        $query->close();
        $conn->close();

        if($result == false){
            echo("Query failed.");
            exit();
        }

        //Get password hash from DB
        $row = $result->fetch_assoc();

        if($row == NULL){
            echo("Invalid username");
            exit();
        } elseif($row == false){
            echo("Results failed.");
            exit();
        }

        $db_pass = $row["user_password"];

        if(password_verify($password, $db_pass)) {
            echo("Login success!");
            session_start();
            $_SESSION['auth'] = 'true';
            $_SESSION['username'] = $username;
            header('location:postlogin.php');
        } else {
            echo("Login failed!");
        }
    }
?>