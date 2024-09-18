<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$addPictureToCategory = 'ALTER TABLE categories ADD COLUMN image VARCHAR(255) AFTER description';
$pdo->exec($addPictureToCategory);
echo 'Table modified successfully';