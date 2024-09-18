<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$createUserTable = "CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(32) NOT NULL UNIQUE, 
password VARCHAR(255) NOT NULL, 
email VARCHAR(255) NOT NULL UNIQUE, 
role ENUM('administrator','moderator','user') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

$pdo->exec($createUserTable);
echo 'Table created successfully';
