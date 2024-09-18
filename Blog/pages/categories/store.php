<?php
require_once("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$name = htmlspecialchars($_POST['name']);
$description = htmlspecialchars(($_POST['description']));
$targetfolder = "../../images/categories/";
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
        $imagename = basename($_FILES['file']['name']);
        $query = "INSERT INTO categories (name, description, image) values (:name , :description, :image)";
        $parameters = ['name' => $name, 'description' => $description, 'image' => $imagename];
        $statement = $pdo->prepare($query);
        $result = $statement->execute($parameters);
        echo "category added successfully";
    } else {
        echo 'An error has occurred, please try again.<br>';
    }
}

//var_dump($targetfile);
