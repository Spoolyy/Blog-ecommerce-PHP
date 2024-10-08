<?php
session_start();
$quantity = 0;
$cartTotalPrice = 0;
foreach ($_SESSION['cart'] as $product) {
    $cartTotalPrice += $product['price'] * $product['quantity'];
    $quantity += $product['quantity'];
}

$itemsInCart = ['count'=> $quantity, 'price' => $cartTotalPrice];
echo json_encode($itemsInCart);
