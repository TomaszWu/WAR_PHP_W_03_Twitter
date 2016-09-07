<?php

session_start();
if(!isset($_SESSION['userId'])){
    header('Location: login.php');
}


var_dump($_SESSION);



if($_SERVER['REQUEST_METHOD'] =='POST'){
    if(isset($_POST['messageToAdd']) && isset($_SESSION['userId'])){
        require_once 'src/Message.php';
        require_once 'connection.php';
        $messageToAdd = $_POST['messageToAdd'];
        $userId = $_SESSION['userId'];
        
        $message = new Message();
        $message->setUserId($userId);
        $message->setMessage($messageToAdd);
        
       // $newMessage = Message::saveTheMessageToTheDB($conn, $userId, $messageToAdd);
        
        
        if($message->saveTheMessageToTheDB($conn)){
            echo 'tak';
        } else {
            echo 'nie';
        }
    }
}

?>

<html>
    <head>
         <meta charset="utf-8">  
    </head>
    <body>
         Strona główna
         
        <form method="POST" action="#">
            <textarea name="messageToAdd" rows="8" cols="40">Wpisz wiadomość</textarea>
            <br>
            <input type="submit">
        </form>
        
       
        <?php
        if(isset($_SESSION['userId'])){
            echo '<a href="logout.php">Logout</a>';
        }
        ?>
        
        
        
        
    </body
</html>