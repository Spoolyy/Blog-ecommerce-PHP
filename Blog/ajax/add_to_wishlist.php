<?php
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
$user_id = $_SESSION['id'];
$itemID = filter_input(INPUT_POST, 'product', FILTER_VALIDATE_INT);
$query = 'SELECT * FROM products where id = :itemID';
$statement = $pdo->prepare($query);
$statement->bindParam(':itemID', $itemID, PDO::PARAM_INT);
$statement->execute();
$product = $statement->fetch();

$query = 'SELECT * FROM wishlists WHERE product_id = :itemID AND user_id = :user_id';
$parameters = ['user_id' => $user_id, 'itemID' => $itemID];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);
$AlreadyFAV = $statement->fetch();


if (!$AlreadyFAV) {
    $status = true;
    $query = "INSERT INTO wishlists (user_id, product_id) values (:user_id , :itemID)";
    $parameters = ['user_id' => $user_id, 'itemID' => $itemID];
    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);
} else {
    $status = false;
    $query = "DELETE FROM wishlists WHERE user_id = :user_id and product_id = :product_id";
    $parameters = ['user_id' => $user_id, 'product_id' => $itemID];
    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);
}

$query = 'SELECT * FROM wishlists';
$statement = $pdo->prepare($query);
$statement->execute();
$itemsInWishlist = $statement->rowCount();

$itemsInWishlist = ['response' => true, 'itemID' => $itemID, 'status' => $status, 'items'=> $itemsInWishlist];
echo json_encode($itemsInWishlist);