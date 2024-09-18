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
$query = 'SELECT * FROM users limit :limit OFFSET :offset';
$statement = $pdo->prepare($query);
$statement->bindParam(':limit', $limit, PDO::PARAM_INT);
$statement->bindParam(':offset', $offset, PDO::PARAM_INT);
$statement->execute();

$users = $statement->fetchAll(PDO::FETCH_ASSOC);

$query = 'SELECT count(*) as records FROM users';
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
    <style>
        .pagination {
            display: inline-block;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
        }

        .pagination a.active {
            background-color: #3089cb;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="flex flex-col justify-center items-center h-screen w-full font-Roboto text-xl font-semibold space-y-4">
        <h1>A total of <?php echo $userRecords[0]['records'] ?> records were found.</h1>
        <table class="rounded-lg">
            <tr>
                <th class="border-black border-2 p-2">ID</th>
                <th class="border-black border-2 p-2">Username</th>
                <th class="border-black border-2 p-2">Email</th>
                <th class="border-black border-2 p-2">User Role</th>
            </tr>
            <?php
            foreach ($users as $user) {
            ?>
                <tr>
                    <td class="border-black border-2 p-2"><?= $user['id'] ?></td>
                    <td class="border-black border-2 p-2"><?= $user['username'] ?></td>
                    <td class="border-black border-2 p-2"><?= $user['email'] ?></td>
                    <td class="border-black border-2 p-2"><?= $user['role'] ?></td>
                    <td>
                        <form action="destroy.php" method="post">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            <button type="submit" class="bg-red-600 rounded-lg text-black p-2">Delete</button>
                        </form>
                    </td>
                    <td>
                        <button class="bg-blue-400 rounded-lg text-black p-2"><a href="edit.php?id=<?= $user['id'] ?>">Edit</a></button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
        <div class="pagination">
            <a href="?page=<?php echo max(1, $page - 1); ?>">&laquo;</a>
            <?php
            $maxpages = ceil($userRecords[0]['records'] / $limit);
            $page = max(1, min($page, $maxpages));
            $startpage = max(1, $page - 2);
            $endpage = min($maxpages, $page + 3);
            for ($i = $startpage; $i <= $endpage; $i++) {
                $activeclass = '';
                if ($page == $i) {
                    $activeclass = ' class="active" ';
                }
            ?>
                <a <?= $activeclass ?> href="?page=<?php echo $i ?>"><?php echo $i ?></a>
            <?php }
            ?>
            <a href="?page=<?php echo min($maxpages, $page + 1); ?>">&raquo;</a>
        </div>
    </div>
</body>

</html>