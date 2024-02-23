<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicons/favicon-16x16.png">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>short-url-hub</title>
</head>


<body>
    <div class="bg-name">short-url-hub</div>
    <main class="app">
        <div class="app__inner">


            <div class="app__title">Введите свою ссылку ниже -
                и мы создадим для вас короткую версию,
                которую легко передать другу:</div>

            <form class="app__form" action="link-db.php">
                <input type="url" name="link" placeholder="https//example.com" required>
                <input type="submit" value="send">
            </form>


        </div>
    </main>
</body>

</html>