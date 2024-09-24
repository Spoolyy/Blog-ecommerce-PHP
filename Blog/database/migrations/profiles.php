<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createProfilesTable = "CREATE TABLE profiles (
id INT AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(32) NOT NULL,
lastname VARCHAR(32) NOT NULL,
age INT NOT NULL,
user_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

$pdo->exec($createProfilesTable);
echo 'Table created successfully';