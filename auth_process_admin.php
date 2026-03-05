<?php

session_start();
require_once 'config_admin.php';

if (isset($_POST['register_btn'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $check_email = $conn->query("SELECT email FROM admi WHERE email ='$email'");
    if($check_email->num_rows > 0){
        $_SESSION['alerts'][]=[
            'type' => 'error',
            'message' => 'Email already registerd!'
        ];
        $_SESSION['active_form'] = 'register';
    }else{
        $conn->query("INSERT INTO admi(name,email,password) VALUES('$name','$email','$password')");
        $_SESSION['alerts'][]=[
        'type' => 'success',
        'message' => 'Registration successful!'
        ];
        $_SESSION['active_form'] = 'login';
    }
    header("Location: Admin_Site.php");
 exit();   
}

if (isset($_POST["login_btn"])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admi WHERE email = '$email'");
    $users = $result->num_rows > 0 ? $result->fetch_assoc() : null;

    if($user && password_verify($password,$users['password'])){
    $_SESSION['name'] = $users['name'];
    $_SESSION['alerts'][]=[
        'type' => 'success',
        'message' => 'Login successful!'
    ];
    
    }else{
        $_SESSION['alerts'][]=[
            'type' => 'error',
            'message' => 'Invalid email or password!'
        ];
        $_SESSION['active_form'] = 'login';
    }
    
    header('Location: Admin_Site.php');
    exit();
}

    ?>
