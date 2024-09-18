<?php
require_once("../../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$select = 'SELECT id, name FROM categories';
$statement = $pdo->prepare($select);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="flex justify-center items-center h-screen bg-slate-400">
        <div class="bg-white p-8 rounded-lg border border-slate-600">
            <form enctype="multipart/form-data" action="store.php" method="post" class="flex flex-col space-y-4 text-center">
                <p class="text-lg font-semibold">Insert the product name</p>
                <input type="text" name="name" placeholder="Name" class="py-4 px-6 text-lg rounded-lg border border-slate-600 shadow-md shadow-black hover:-translate-y-1 duration-200">
                <p class="text-lg font-semibold">Insert a description (optional)</p>
                <input type="text" name="description" placeholder="Description" class="py-4 px-6 text-lg rounded-lg border border-slate-600 shadow-md shadow-black hover:-translate-y-1 duration-200">
                <p class="text-lg font-semibold">Insert a price:</p>
                <input type="text" name="price" placeholder="Price" class="py-4 px-6 text-lg rounded-lg border border-slate-600 shadow-md shadow-black hover:-translate-y-1 duration-200">
                <p class="text-lg font-semibold">Amount:</p>
                <input type="text" name="stock" placeholder="0" class="py-4 px-6 text-lg rounded-lg border border-slate-600 shadow-md shadow-black hover:-translate-y-1 duration-200">
                <p class="text-lg font-semibold">Select a category:</p>
                <select name="category_id" class="py-4 px-6 text-lg rounded-lg border border-slate-600 shadow-md shadow-black hover:-translate-y-1 duration-200">
                    <?php
                    foreach ($categories as $category) {
                    ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <p class="text-lg font-semibold">Insert an image (optional)</p>
                <input type="file" name="file">
                <button type="submit" class="bg-blue-500 border border-gray-700 rounded-lg text-lg py-4 px-6 font-semibold text-white shadow-md shadow-black hover:-translate-y-1 duration-200">List product</button>
            </form>
        </div>
    </div>
</body>

</html>
<?php ?>