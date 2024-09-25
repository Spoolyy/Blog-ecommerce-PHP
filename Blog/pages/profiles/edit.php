<?php
require_once("../../config/config.php");
require_once("../isLogged.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$user_id = $_SESSION['id'];


$query = "SELECT * FROM profiles WHERE user_id = :user_id";
$parameters = ["user_id" => $user_id];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);
$profiles = $statement->fetchAll(PDO::FETCH_ASSOC);

if (!isset($profiles[0])) {
    $query = "INSERT INTO profiles (user_id, firstname, lastname, age) VALUES (:user_id, '', '', '2024-09-25')";
    $parameters = ['user_id' => $user_id,];
    $statement = $pdo->prepare($query);
    $statement->execute($parameters);

    $query = "SELECT * FROM profiles WHERE user_id = :user_id";
    $parameters = ["user_id" => $user_id];
    $statement = $pdo->prepare($query);
    $result = $statement->execute($parameters);
    $profiles = $statement->fetchAll(PDO::FETCH_ASSOC);
}

//use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        offWhite: '#FAF9F6',
                        offBlack: '#313639',
                        dudaCyan: '#c1d6d9'
                    },
                    fontFamily: {
                        'Roboto': ['Roboto'],
                    }
                },
            },
        }
    </script>
</head>

<body>
    <div class="flex justify-center items-center font-Roboto text-2xl h-screen w-full">
        <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="flex flex-col justify-center items-center space-y-3 font-semibold">
                <div id="firstname" class="flex flex-col justify-center items-center space-y-1">
                    <h1>first name</h1>
                    <input value="<?= $profiles[0]['firstname'] ?>" placeholder="New first name" type="text" name="firstname" class="border-1 border-black text-center p-2">
                </div>
                <div id="lastname" class="flex flex-col justify-center items-center space-y-1">
                    <h1>last name</h1>
                    <input value="<?= $profiles[0]['lastname'] ?>" placeholder="New last name" type="text" name="lastname" class="border-1 border-black text-center p-2">
                </div>
                <div id="age" class="flex flex-col justify-center items-center space-y-1">
                    <h1>date of birth</h1>
                    <input type="date" value="<?= $profiles[0]['age'] ?>" name="age" class="border-1 border-black text-center p-2">
                </div>
                <p>Insert a profile avatar (optional)</p>
                <input type="file" name="file">
                <button type="submit" class="bg-green-600 text-white p-3 rounded-md shadow-lg">Confirm</button>
            </div>
        </form>
    </div>
</body>

</html>