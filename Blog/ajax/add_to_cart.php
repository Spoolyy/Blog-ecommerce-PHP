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

$alreadyInCart = false;
$itemQuantity = 1;
foreach ($_SESSION['cart'] as &$item) {
    if ($item['id'] == $itemID) {
        $item['quantity'] += 1;
        $itemQuantity = $item['quantity'];
        $alreadyInCart = true;
    }
}
if ($alreadyInCart == false) {
    $_SESSION['cart'][] = ['id'=> $_POST['product'], 'price'=> $price[0]['price'], 'quantity' => 1 ];
}

$quantity = 0;
$cartTotalPrice = 0;
foreach ($_SESSION['cart'] as $product) {
    $cartTotalPrice += $product['price'] * $product['quantity'];
    $quantity += $product['quantity'];
}
$itemsInCart = ['count'=> $quantity, 'price' => $cartTotalPrice, 'itemQuantity' => $itemQuantity ];
echo json_encode($itemsInCart);;