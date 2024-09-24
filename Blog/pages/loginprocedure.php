<?php
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

$usernameSelection = "SELECT * FROM users WHERE username = :username";
$statement = $pdo->prepare($usernameSelection);
$statement -> bindParam('username', $username, PDO::PARAM_STR);
$statement -> execute();
$userVerified = $statement->fetchAll(PDO::FETCH_ASSOC);
var_dump($userVerified);

if (count($userVerified) == 1) {
    if (password_verify($password, $userVerified[0]['password'])) {
        session_start();
        $_SESSION['id'] = $userVerified[0]['id'];
        $_SESSION['username'] = $userVerified[0]['username'];
        header('Location: index.php');
    }
    else {
        header('Location: loginpage.php?error=Wrong credentials');
    }
}
else {
    header('Location: loginpage.php?error=User not found');
}