<?php

session_start();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_SESSION['userId'])){
        require_once 'src/Tweet.php';
require_once 'connection.php';
        $userId = $_SESSION['userId'];
        $allUsersTweets = Tweet::checkTheInfoAboutUser($conn, $userId);
        var_dump($allUsersTweets);
        
    }
}
