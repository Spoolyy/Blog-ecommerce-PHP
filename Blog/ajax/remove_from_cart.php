<?php
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$itemID = filter_input(INPUT_POST, 'product', FILTER_VALIDATE_INT);
$itemQuantity = 0;
foreach ($_SESSION['cart'] as $index => $item_in_cart) {
    if ($item_in_cart['id'] == $itemID) {
        if ($item_in_cart['quantity'] > 1) {
            $_SESSION['cart'][$index]['quantity'] -= 1;
            $itemQuantity = $_SESSION['cart'][$index]['quantity'];
        } else {
            unset($_SESSION['cart'][$index]);
        }
    }
}

$itemsInCart = ['itemQuantity' => $itemQuantity ];
echo json_encode($itemsInCart);