<?php
require_once("../../config/config.php");
// Establish the PDO connection
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    // Validate and sanitize inputs
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $name = htmlspecialchars(trim($_POST["name"] ?? ''));
    $description = htmlspecialchars(trim($_POST["description"] ?? ''));
    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
    $stock = filter_input(INPUT_POST, "stock", FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, "category_id", FILTER_VALIDATE_INT);

    // Check if inputs are valid
    if ($id === false || $price === false || $stock === false || $category_id === false || empty($name) || empty($description)) {
        throw new Exception("Invalid input data.");
    }

    // File upload handling
    $targetfolder = "../../images/products/";
    $image = null;

    if (!empty($_FILES['file']['name'])) {
        $targetfile = $targetfolder . basename($_FILES['file']['name']);
        $fileExtension = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $fileSize = $_FILES['file']['size'];
            $mimeType = mime_content_type($_FILES['file']['tmp_name']);
            $validMimeTypes = ['image/jpeg', 'image/png'];

            if ($fileSize <= 5000000 && in_array($mimeType, $validMimeTypes)) {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetfile)) {
                    $image = basename($_FILES['file']['name']);
                } else {
                    throw new Exception("Failed to move uploaded file.");
                }
            } else {
                throw new Exception("File is either too large or has an unsupported format.");
            }
        } else {
            throw new Exception("Invalid file extension. Only JPG, JPEG, and PNG are allowed.");
        }
    }

    // Prepare and execute the SQL query
    $query = "UPDATE products SET 
                name = :name, 
                description = :description, 
                price = :price, 
                stock = :stock, 
                category_id = :category_id" .
        ($image ? ", image = :image" : "") .
        " WHERE id = :id";

    $parameters = [
        ":id" => $id,
        ":name" => $name,
        ":description" => $description,
        ":price" => $price,
        ":stock" => $stock,
        ":category_id" => $category_id
    ];

    if ($image) {
        $parameters[":image"] = $image;
    }

    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);

    if ($result) {
        echo "Product modified successfully.";
    } else {
        throw new Exception("Failed to update the product.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
