<?php
require_once ("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$addPictureToProfiles = 'ALTER TABLE profiles ADD COLUMN image VARCHAR(255) AFTER age';
$pdo->exec($addPictureToProfiles);
echo 'Table modified successfully';