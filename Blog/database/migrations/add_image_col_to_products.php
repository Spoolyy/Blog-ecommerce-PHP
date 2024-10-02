<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$addImageToProducts = 'ALTER TABLE products ADD COLUMN image VARCHAR(255) after description';
$pdo->exec($addImageToProducts);
echo 'Table created successfully';