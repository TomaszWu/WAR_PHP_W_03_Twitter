<?php

$serverName = 'localhost'; //127.0.0.1
$userName = 'root';
$password = 'coderslab';
$database = 'Twitter';


$conn = new mysqli($serverName, $userName, $password, $database);

if ($conn->connect_error) {
    die("Connect error: " . $conn->connect_error);
}
$conn->set_charset('utf8');




