<?php
if(isset($_GET["id"])){
    $id = $_GET["id"];

    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "users_db";
    //connect to database
    $conn = new mysqli($host, $username, $password, $database);
    
    $sql = "DELETE FROM users WHERE id = $id";
    $result = $conn->query($sql);


    }

    header("location: login_clients.php");
    exit();


?>