<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$name = htmlspecialchars($_POST["name"]);

$query = "INSERT INTO tags (name) VALUES (:name)";
$parameters = ["name" => $name];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);

header("Location: create.php");