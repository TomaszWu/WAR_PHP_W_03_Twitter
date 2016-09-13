<?php

require_once '../src/User.php';
require_once '../connection.php';


$user = User::loadUserById($conn, 48);
var_dump($user);
$user->setName('New name4');
var_dump($user->saveToDB($conn));
$user = User::loadUserById($conn, 48);
var_dump($user);






$conn->close();
$conn = 0;


/*
 * 
 
$cinemas = array();
$cinemasQuery = "SELECT * FROM Cinemas";
$result = $conn->query($cinemasQuery);
if($result->num_rows > 0) { 
	while($row = $result->fetch_assoc()) { // dopóty gdy jest jeszcze jakiś wiersz w wyniku zapytania.
		$cinemas[] = $row;
	}
}
 */