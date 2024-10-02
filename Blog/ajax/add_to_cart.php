<?php
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$itemID = filter_input(INPUT_POST, 'product', FILTER_VALIDATE_INT);
$pricequery = "SELECT price FROM products where id = :itemID";
$statement = $pdo->prepare($pricequery);
$statement->bindParam(':itemID', $itemID, PDO::PARAM_INT);
$statement->execute();
$price = $statement->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['cart'][] = ['id'=> $_POST['product'], 'price'=> $price[0]['price']];
$cartTotalPrice = 0;
foreach ($_SESSION['cart'] as $product) {
    $cartTotalPrice += $product['price'];
}

$itemsInCart = ['count'=> count($_SESSION['cart']), 'price'=> $cartTotalPrice];
echo json_encode($itemsInCart);