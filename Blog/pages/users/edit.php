<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
// Set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//var_dump($_POST);
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

$query = "SELECT * FROM users WHERE id = :id";
$parameters = ["id" => $id];
$statement = $pdo->prepare($query);
$result = $statement->execute($parameters);
$users = $statement->fetchAll(PDO::FETCH_ASSOC);

//var_dump($users);
//header("Location: index.php");

// use ALTER TABLE users AUTO_INCREMENT = 1; to reset the id field, to do this the table must be empty
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
        <form action="update.php" method="post">
            <div class="flex flex-col justify-center items-center space-y-3 font-semibold">
                <div id="username" class="flex flex-col justify-center items-center space-y-1">
                    <h1>Enter your new username</h1>
                    <input value="<?= $users[0]['username'] ?>" placeholder="new username" type="text" name="username" class="border-1 border-black text-center p-2">
                </div>
                <div id="email" class="flex flex-col justify-center items-center space-y-1">
                    <h1>Enter your new email address</h1>
                    <input value="<?= $users[0]['email'] ?>" placeholder="new email address" type="text" name="email" class="border-1 border-black text-center p-2">
                </div>
                <div id="password" class="flex flex-col justify-center items-center space-y-1">
                    <h1>Enter your new password</h1>
                    <input type="text" placeholder="new password" name="password" class="border-1 border-black text-center p-2">
                </div>
                <input type="hidden" name="id" value="<?= $users[0]['id'] ?>">
                <button type="submit" class="bg-green-600 text-white p-3 rounded-md shadow-lg">Confirm</button>
            </div>
        </form>
    </div>
</body>

</html>