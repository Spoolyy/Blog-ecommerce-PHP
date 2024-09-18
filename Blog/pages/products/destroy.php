<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$query = "DELETE FROM products WHERE id = :id";
$parameters = ["id" => $id];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);

header("Location: index.php");

// use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
