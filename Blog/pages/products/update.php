<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$name = htmlspecialchars($_POST["name"]);
$description = htmlspecialchars($_POST["description"]);
$price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
$stock = filter_input(INPUT_POST, "stock", FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, "category_id", FILTER_VALIDATE_INT);

$targetfolder = "../../images/products/";
$targetfile = $targetfolder . basename($_FILES['file']['name']);
$canBeUploaded = true;
$fileExtension = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));
$isImage = getimagesize($_FILES['file']['tmp_name']);

if ($isImage !== false) {
    $canBeUploaded = true;
} else {
    $canBeUploaded = false;
    echo 'The file you are trying to upload is not an image.<br>';
}

if (file_exists($targetfile)) {
    $canBeUploaded = false;
    echo 'The file you are trying to upload already exists.<br>';
}

if ($_FILES['file']['size'] > 5000000) {
    $canBeUploaded = false;
    echo 'Your file is too big, compress it or choose another.<br>';
}

if ($fileExtension !== 'jpg' && $fileExtension !== 'png' && $fileExtension !== 'jpeg') {
    $canBeUploaded = false;
    echo 'This file format is not supported, please convert to either JPEG or PNG.<br>';
}

if ($canBeUploaded === false) {
    echo 'File upload process has been interrupted.<br>';
} else {
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)) {
        $image = basename($_FILES['file']['name']);
        $query = "UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, category_id = :category_id, image = :image WHERE id = :id";
        $parameters = ["id" => $id, "name" => $name, "description" => $description, "price" => $price, "stock" => $stock, "category_id" => $category_id, "image" => $image];
        $statement = $pdo->prepare($query);
        $result = $statement->execute($parameters);
        var_dump($parameters);
        echo "product modified successfully";
    } else {
        echo 'An error has occurred, please try again.<br>';
    }
}
//header("Location: index.php");

// use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
