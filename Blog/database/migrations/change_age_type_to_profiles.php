<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$change_age_type = "ALTER TABLE profiles MODIFY COLUMN age DATE";
$pdo->exec($change_age_type);
echo ('age type changed successfully');