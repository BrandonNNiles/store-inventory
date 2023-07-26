<?php
    function view_redirect($require_auth, $perm_level){
        if($require_auth){ //require logins?
            session_start();
            if(!$_SESSION['auth']){
                header("location:login.php"); //redirect unauthed users
                exit();
            }
            require __DIR__ . '/db.php';
            $perms = get_value($_SESSION["username"], "permission");
            if($perms < $perm_level){
                header("location:../redirects/invalidperms.php");
                exit();
            }
        }
    }
?>