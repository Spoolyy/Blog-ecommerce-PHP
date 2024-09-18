<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$createPostsTable = "CREATE TABLE posts (
id INT AUTO_INCREMENT PRIMARY KEY, 
user_id INT NOT NULL UNIQUE,
title VARCHAR(64) NOT NULL,
content TEXT NOT NULL,
slug VARCHAR(255) NOT NULL UNIQUE,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
status ENUM('draft','published','removed') DEFAULT 'draft',
FOREIGN KEY (user_id) REFERENCES users(id) )";

$pdo->exec($createPostsTable);
echo 'Table created successfully';
