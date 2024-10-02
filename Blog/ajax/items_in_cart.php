<?php
session_start();

$cartTotalPrice = 0;
foreach ($_SESSION['cart'] as $product) {
    $cartTotalPrice += $product['price'];
}

$itemsInCart = ['count'=> count($_SESSION['cart']), 'price' => $cartTotalPrice];
echo json_encode($itemsInCart);
