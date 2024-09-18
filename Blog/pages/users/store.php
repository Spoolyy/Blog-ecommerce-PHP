<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$username = htmlspecialchars($_POST["username"]);
$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
$email = htmlspecialchars($_POST["email"]);
$role = htmlspecialchars($_POST["role"]);

$query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
$parameters = ["username" => $username, "password" => $password, "email" => $email, "role" => $role];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);

header("Location: create.html");

// use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
