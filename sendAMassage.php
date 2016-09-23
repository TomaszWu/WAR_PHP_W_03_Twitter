<?php

session_start();





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['receiverId']) && isset($_SESSION['userId'])) {
        
        // nie wiem, czy pobieranie danych z trzech różnych źródel jak poniżej to dobra praktyka? 
        $receiverId = $_GET['receiverId'];
        $senderId = $_SESSION['userId'];
        $massage = $_POST['massageToSend'];
        if ($receiverId == $senderId) {
            echo 'Błąd, nie można wysłać wiadomości do samego siebie!';
        } else {
            require_once 'connection.php';
            require_once 'src/Massage.php';
            $massageToSend = New Massage();
            $massageToSend->setReceiverId($receiverId);
            $massageToSend->setSenderId($senderId);
            $massageToSend->setMassage($massage);
            $massageToSend->setStatus(0);
            if($massageToSend->addAMassageToTheDB($conn)){
                echo 'Wiadomość została wysłana poprawnie!';
            } else {
                echo 'blad';
            }
            
        }
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
        
        <form method="POST" action="#">
            <label>Wyślij wiadomość</label>
            <br>
            <textarea name="massageToSend" rows="8" cols="40" maxlength="140"></textarea>
            <br>
            <input type="submit" value="Wyślij prywatną wiadomość do użytkownika">
            
        </form>
        
    </body>
</html>