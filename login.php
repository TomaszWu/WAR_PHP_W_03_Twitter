<?php

require_once 'src/User.php';
require_once 'connection.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['email']) && strlen(trim($_POST['email'])) > 4  
            && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5){
             
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $user = User::login($conn, $email, $password);
            
            
            
            if($user){
                $_SESSION['userId'] = $user->getId();
                header('Location: index.php');
            } else {
                echo 'Niepoprawne dane logowania';
            }
    }
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['registration']) && $_GET['registration'] == 'createNewAccount'){
        header('Location: register.php');
    }
}

?>


<html>
    <head> </head>
    <body>
        <form method="POST">
            <label>
                E-mail:<br>
                <input type="text" name="email">
            </label>
            <br>
            <label>
                Password:<br>
                <input type="password" name="password">
            </label>
            <br>
            <input type="submit" value="Login">
        </form>
        <a href="login.php?registration=createNewAccount">Przejście to strony rejestracji</a>
            
    </body> 