<?php
require_once("../../config/config.php");

$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
$limit = 15;
if (empty($page)) {
    $page = 1;
}
$offset = ($page - 1) * $limit;
$category_id = filter_input(INPUT_GET, "category_id", FILTER_VALIDATE_INT);

$parameters = ["limit" => $limit, "offset" => $offset];
$query = 'SELECT * FROM products WHERE category_id = :category_id limit :limit OFFSET :offset';
$statement = $pdo->prepare($query);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = 'SELECT count(*) as records FROM products WHERE category_id = :category_id';
$statement = $pdo->prepare($query);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$statement->execute();
$totalItems = $statement->fetchAll(PDO::FETCH_ASSOC);

$avgprice = 'SELECT avg(price) as average, sum(price) as total FROM products WHERE category_id = :category_id';
$statement = $pdo->prepare($avgprice);
$statement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
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
    <div class="bg-slate-200 h-screen flex flex-col items-center justify-center mx-auto space-y-2">
        <div class="max-w-7xl flex flex-col items-center bg-white rounded-lg justify-center p-4">
            <p id="average_price" class="text-2xl font-semibold">Average price of items: $<?= number_format($average_and_total[0]['average'], 2)?></p>
            <p id="average_price" class="text-2xl font-semibold">Total price of items: $<?= $average_and_total[0]['total']?></p>
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
                        <button type="submit" class="bg-red-600 text-white p-2 rounded-lg text-xl">Delete</button>
                        <button class="bg-blue-400 text-black p-2 rounded-lg text-xl"><a href="edit.php?id=<?= $product['id'] ?>">Edit</a></button>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>