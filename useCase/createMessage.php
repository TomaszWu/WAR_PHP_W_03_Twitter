<?php

require_once '../src/Tweet.php';
require_once '../connection.php';

session_start();


// var_dump($_SESSION);




$message13 = new Tweet();
$message13->setUserId($_SESSION['userId']);
$message13->setTweet('To jest wiadomosc testowa nr33!');

// var_dump($message13->saveTheTweetToTheDB($conn));

$tweets = Tweet::loadAllTweets($conn);
var_dump($tweets);