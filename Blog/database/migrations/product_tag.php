<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createProduct_TagTable = 'CREATE TABLE product_tag (
id INT AUTO_INCREMENT PRIMARY KEY,
product_id INT NOT NULL,
tag_id INT NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)';

$pdo->exec($createProduct_TagTable);
echo 'Table created successfully';