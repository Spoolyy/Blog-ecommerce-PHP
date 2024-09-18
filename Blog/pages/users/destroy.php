<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$query = "DELETE FROM users WHERE id = :id";
$parameters = ["id" => $id];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);

header("Location: index.php");

// use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
