<?php
require_once("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$roles = ['administrator', 'moderator', 'user'];

for ($i = 0; $i < 1000; $i++) {
    $username = "username" . $i;
    $email = "email" . $i . "@gmail.com";
    $randrole = rand(0, 2);
    $role = $roles[$randrole];
    $password = password_hash("password" . $i, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)";
    $parameters = ["username" => $username, "password" => $password, "email" => $email, "role" => $role];
    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);
}

echo "executed successfully";