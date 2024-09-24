<?php
require_once("../config/config.php");
$pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    <div id="container" class="bg-offBlack font-Roboto">
        <div class="flex flex-col space-y-6 items-center justify-center h-screen max-w-7xl mx-auto">
            <div class="bg-gray-200 rounded-lg p-6 w-full text-3xl text-center font-semibold shadow-lg">
                <p>Log into your account</p>
            </div>
            <div class="grid grid-cols-3 space-x-6 w-full">
                <div class="main-left col-span-2">
                    <form action="loginprocedure.php" method="post" class="bg-gray-200 rounded-lg p-6 space-y-6 shadow-lg">
                        <div class="space-y-4 flex flex-col justify-between pt-4">
                            <p class="text-2xl font-semibold">Insert your username:</p>
                            <input type="text" name="username" id="username" placeholder="username" class="px-4 py-2 text-xl rounded-lg shadow-lg w-full">
                        </div>
                        <div class="space-y-4 flex flex-col justify-between">
                            <p class="text-2xl font-semibold">Insert your password:</p>
                            <input type="text" name="password" id="password" placeholder="password" class="px-4 py-2 text-xl rounded-lg shadow-lg w-full">
                        </div>
                        <button class="px-4 py-2 text-2xl font-semibold bg-cyan-100 rounded-lg shadow-lg pb-4">Log-in</button>
                    </form>
                </div>
                <div class="main-right col-span-1">
                    <div class="bg-gray-200 rounded-lg p-6 shadow-lg">
                        <p>Don't have an an account?</p>
                        <p>Create one <a href="users/create.html"><strong>HERE</strong></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let verify = window.location.search
        let urlparams = new URLSearchParams(verify)
        let exc = 'error'
        if (urlparams.has(exc)) {
            let error = urlparams.get(exc)
            window.alert(error)
        }
    </script>
</body>

</html>