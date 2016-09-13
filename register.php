<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['name']) && strlen(trim($_POST['name'])) > 0
            && isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5 
            && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5
            && isset($_POST['retyped_password'])
            && trim($_POST['password']) == trim($_POST['retyped_password'])){
        
                require_once 'src/User.php';
                require_once 'connection.php';
                
                $user = new User();
                $user->setName(trim($_POST['name']));
                $user->setEmail(trim($_POST['email']));
                $user->setPassword(trim($_POST['password']));
                if($user->saveToDB($conn)){
                    echo 'Udało się zarejstrować';
                    header('Location: index.php');
                } else {
                    echo "Blad rejestracji";
                }
        
    } else {
        echo "bledne dane formularza";
    }
}            
?>


<html>
    <head></head>
    <body>
        <form method="POST">
            <label>
                Name:<br>
                <input type="text" name="name">
            </label>
            <br>
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
            <label>
                Retype password:<br>
                <input type="password" name="retyped_password">
            </label>
            <br>
            <input type="submit" value="Register">    
            
        </form>
    </body>
</html>

