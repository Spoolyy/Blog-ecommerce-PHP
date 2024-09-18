<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$createProductsTable = "CREATE TABLE products (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL,
description TEXT,
price DECIMAL(10,2) NOT NULL,
stock INT DEFAULT 0,
category_id INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

$pdo->exec($createProductsTable);
echo 'Table created successfully';

// $temporary = 'ALTER TABLE table_name ADD COLUMN column_name type after existing_column';
// $pdo->exec($temporary);
// echo 'Table created successfully';