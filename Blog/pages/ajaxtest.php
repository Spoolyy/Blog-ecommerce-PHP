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
    <script
        src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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
    <div class="bg-offBlack h-screen flex flex-col items-center justify-center">
        <div class="flex flex-col items-center justify-center space-y-2">
            <!-- <input type="text" id="name" class="p-4 rounded-lg text-xl hover:shadow-lg hover:-translate-y-2 duration-300">
            <input type="text" id="textfield" class="p-4 rounded-lg text-xl hover:shadow-lg hover:-translate-y-2 duration-300">
            <button id="button" class=" bg-blue-300 rounded-lg border border-black p-4 text-xl">Click Here</button> -->

            <input type="number" id="firstnumber" class="p-4 rounded-lg text-xl hover:shadow-lg hover:-translate-y-2 duration-300">
            <input type="number" id="secondnumber" class="p-4 rounded-lg text-xl hover:shadow-lg hover:-translate-y-2 duration-300">
            <input id="result" class="p-4 rounded-lg text-xl hover:shadow-lg hover:-translate-y-2 duration-300"></input>
            <button id="calculate" class=" bg-blue-300 rounded-lg border border-black p-4 text-xl">Click Here</button>
        </div>
    </div>
    <script>
        // $('#button').click(function() {
        //     $.ajax({
        //         url: '../ajax/ajaxScripts.php',
        //         type: 'POST',
        //         data: {
        //             name: $('#name').val()
        //         },
        //         success: function(response) {
        //             $('#textfield').val(response)
        //         },
        //         error: function(xhr, status, error) {
        //             ('#textfield').val(error)
        //         }
        //     })
        // })
        $('#calculate').click(function() {
            $.ajax({
                url: '../ajax/ajaxScripts.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    firstnumber: $('#firstnumber').val(),
                    secondnumber: $('#secondnumber').val()
                },
                success: function(response) {
                    $('#result').val(response.response)
                },
                error: function(xhr, status, error) {
                    ('#result').val(error)
                }
            })
        })
    </script>
</body>

</html>