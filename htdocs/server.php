<?php

// connect to database
try {
    $conn  = new mysqli("6.tcp.ngrok.io", "rini", "CP476", "CP476", "14812");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch(Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database');
}
?>