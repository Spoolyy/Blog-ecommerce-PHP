<?php
require_once("../../config/config.php");
require_once("../isLogged.php");
// Establish the PDO connection
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
    // Validate and sanitize inputs
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $date = htmlspecialchars($_POST['age']);
    $user_id = $_SESSION['id'];
    if (DateTime::createFromFormat('Y-m-d', $date)) {
        // Valid date format
        echo "The date is valid.";
    } else {
        // Invalid date format
        echo "The date is invalid.";
    }
    var_dump($date);
    $targetfolder = "../../images/profiles";
    $targetfile = $targetfolder . basename($_FILES['file']['name']);
    $fileExtension = strtolower(pathinfo($targetfile, PATHINFO_EXTENSION));
    $isImage = getimagesize($_FILES['file']['tmp_name']);
    $canBeUploaded = true;

    if ($date === false || empty($firstname) || empty($lastname)) {
        throw new Exception("Invalid input data.");
    }

    // File upload handling
    $targetfolder = "../../images/profiles/";
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
    $query = "UPDATE profiles SET 
            firstname = :firstname, 
            lastname = :lastname, 
            age = :date" .
        ($image ? ", image = :image" : "") .
        " WHERE user_id = :user_id";

    $parameters = [
        ":firstname" => $firstname,
        ":lastname" => $lastname,
        ":date" => $date,
        ":user_id" => $user_id
    ];

    if ($image) {
        $parameters[":image"] = $image;
    }

    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);

    if ($result) {
        echo "Changes applied.";
    } else {
        throw new Exception("Failed to update the product.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
