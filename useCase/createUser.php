<?php

require_once '../src/User.php';
require_once '../connection.php';

$user1 = new User();
$user1->setName('Name1');
$user1->setEmail('email1@email.com');
$user1->setPassword('pass123');


var_dump($user1->saveToDB($conn));





$user2 = new User();
$user2->setName('Name2');
$user2->setEmail('email233@email.com');
$user2->setPassword('pass456');


var_dump($user2->saveToDB($conn));

$user9 = new User();
$user9->setName('Name32');
$user9->setEmail('tes2t@.com');
$user9->setPassword('Na2me3');


var_dump($user9->saveToDB($conn));




$conn->close();
$conn = null;