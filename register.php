<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['name']) && strlen(trim($_POST['name'])) > 0
            && isset($_POST['email']) && strlen(trim($_POST['email'])) >= 5 
            && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5
            && isset($_POST['retyped_password'])
            && trim($_POST['password']) == trim($_POST['retyped_password'])){
        
                require_once 'src/User.php';
                require_once 'connection.php';
                
                $emailToCheck = $_POST['email'];
                
                $query = "SELECT email FROM Users WHERE email = '$emailToCheck'";
                $checkIfThereIsAProblemWithAnEmail = $conn->query($query);
                $user = new User();
                $user->setName(trim($_POST['name']));
                $user->setEmail(trim($_POST['email']));
                $user->setPassword(trim($_POST['password']));
                if (!filter_var($emailToCheck, FILTER_VALIDATE_EMAIL) === false) {
                if($user->saveToDB($conn)){
                    echo 'Udało się zarejstrować';
                    header('Location: index.php');
                } elseif($checkIfThereIsAProblemWithAnEmail && $checkIfThereIsAProblemWithAnEmail->num_rows > 0){
                    echo 'Ten email już istnieje w bazie danych. Prosimy podać nowy.';
                } else {
                    echo "Blad rejestracji";
                }
                } else {
                    echo "$emailToCheck nie jest poprawnym adresem mailowym";
                }
    } else {
        echo "Błędne dane formularza";
    }
    
    $conn->close();
    $conn = null;
}            



?>


<html>
    <head>
         <meta charset="utf-8"> 
    </head>
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
            <br>
            <a href="login.php">Wróć do logowania</a>
        </form>
    </body>
</html>

