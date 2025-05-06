<?php
$host = 'localhost';
$db_name = 'iccartdb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/*
	GET
	POST
	PUT 
	DELETE
*/

?>