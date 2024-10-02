<?php
require_once('isLogged.php');
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$content = htmlspecialchars($_POST['search']);
$search = "%" . $content . "%";

$query = "SELECT * FROM products WHERE name like :search_content";
$statement = $pdo->prepare($query);
$statement->bindParam('search_content', $search, PDO::PARAM_STR);
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$avgprice = "SELECT avg(price) as average, sum(price) as total FROM products WHERE name like :search_content";
$statement = $pdo->prepare($avgprice);
$statement->bindParam('search_content', $search, PDO::PARAM_STR);
$statement->execute();
$average_and_total = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="bg-slate-200 h-screen space-y-6">
        <div class="max-w-7xl mx-auto">
            <div id="navbar" class="w-full bg-gray-200 flex justify-between items-center px-4 py-6 rounded-b-lg text-lg shadow-lg">
                <div class="w-fit flex items-center justify-center">
                    <p>Blogmerce.com</p>
                </div>
                <div class="flex space-x-4">
                    <p class="font-semibold hover:scale-105 duration-200">Home</p>
                    <p class="font-semibold hover:scale-105 duration-200">Products</p>
                    <p class="font-semibold hover:scale-105 duration-200">Categories</p>
                </div>
                <div class="w-fit px-9 flex items-center justify-center">
                    <button class="hover:scale-105 duration-200 hover:font-semibold"><a href="profiles/edit.php"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </a></button>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center mx-auto space-y-2">
            <div class="max-w-7xl flex flex-col items-center bg-white rounded-lg justify-center p-4">
                <p id="average_price" class="text-2xl font-semibold">Average price of items: $<?= number_format($average_and_total[0]['average'], 2) ?></p>
                <p id="average_price" class="text-2xl font-semibold">Total price of items: $<?= $average_and_total[0]['total'] ?></p>
            </div>
            <div class="max-w-7xl grid grid-cols-4 gap-4 bg-white rounded-lg items-center justify-center p-4">
                <?php
                foreach ($products as $product) {
                ?>
                    <div class="bg-slate-300 px-4 py-6 rounded-lg text-center space-y-4">
                        <img id="image" src="../../images/products/<?= $product['image'] ?>" alt="CategoryImage" class="rounded-lg object-cover">
                        <p id="name" class="text-2xl font-bold"><?= $product['name'] ?></p>
                        <p id="description" class="text-xl font-semibold"><?= $product['description'] ?></p>
                        <p id="description" class="text-xl font-semibold">$<?= $product['price'] ?></p>
                        <p id="description" class="text-lg font-semibold">In Stock: <strong><?= $product['stock'] ?></strong></p>
                        <form action="destroy.php" method="post">
                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                            <?php
                            if ($_SESSION['role'] == 'administrator') {
                            ?>
                                <button type="submit" class="bg-red-600 text-white p-2 rounded-lg text-xl">Delete</button>
                                <button class="bg-blue-400 text-black p-2 rounded-lg text-xl"><a href="edit.php?id=<?= $product['id'] ?>">Edit</a></button>
                            <?php
                            }
                            ?>
                            <button class="bg-blue-400 text-black p-2 rounded-lg text-xl">Buy now</button>
                        </form>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>