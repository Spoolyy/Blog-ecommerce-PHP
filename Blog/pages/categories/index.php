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
$parameters = ["limit" => $limit, "offset" => $offset];
$query = 'SELECT * FROM categories limit :limit OFFSET :offset';
$statement = $pdo->prepare($query);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();

$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = 'SELECT count(*) as records FROM categories';
$statement = $pdo->prepare($query);
$statement->execute();
$userRecords = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="bg-slate-200 h-screen flex items-center justify-center mx-auto">
        <div class="max-w-7xl grid grid-cols-4 gap-4 bg-white rounded-lg items-center justify-center p-4">
            <?php
            foreach ($categories as $category) {
            ?>
                <div class="bg-slate-300 px-4 py-6 rounded-lg text-center space-y-4">
                    <img id="image" src="../../images/categories/<?= $category['image'] ?>" alt="CategoryImage" class="rounded-lg object-cover">
                    <p id="name" class="text-2xl font-bold"><?= $category['name'] ?></p>
                    <p id="description" class="text-xl font-semibold"><?= $category['description'] ?></p>
                    <form action="destroy.php" method="post">
                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                        <button type="submit" class="bg-red-600 text-white p-2 rounded-lg text-xl">Delete</button>
                        <button class="bg-blue-400 text-black p-2 rounded-lg text-xl"><a href="edit.php?id=<?= $category['id'] ?>">Edit</a></button>
                    </form>
                    <button class="bg-green-400 text-black p-2 rounded-lg text-xl"><a href="../products/index.php?category_id=<?= $category['id'] ?>">Show Products</a></button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>