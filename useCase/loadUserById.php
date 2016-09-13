<?php



require_once '../src/User.php';
require_once '../connection.php';





$user1 = User::loadUserById($conn, 48);

var_dump($user1);



$user2 = User::loadUserById($conn, 555);

var_dump($user2);


