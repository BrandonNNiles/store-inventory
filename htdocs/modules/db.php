<?php
    //A module containing several useful functions for DB purposes

    //Returns a SQLi connection object with set information
    function sqlconn(){
        //Connection info
        $host = "6.tcp.ngrok.io";
        $user = "brandon";
        $pass = "CP476";
        $db = "CP476";
        $port = "14812";

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