<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Short-url-hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script>
        function validateForm() {

            var inputValue = document.getElementById('textInput').value;
            var trimmedValue = inputValue.trim();
            if (trimmedValue === '') {
                alert('Введи ссылку. Пробелы не допускаются.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<div class="container">
    <p>Введите свою ссылку ниже и мы создадим для вас короткую версию, которую легко передать другу</p>
    <form action="/create" method="get" onsubmit="return validateForm()">
        <form>
            <label for="textInput">Введи ссылку:</label>
            <input type="text" id="textInput" name="link">
            <input type="submit" value="Получить короткую ссылку">
        </form>
    </form>
</div>
<?php
$short_link_by_ip = (new Url()) ->find_short_links_by_ip($_SERVER['REMOTE_ADDR']);
$short_link_by_sid = (new Url()) ->find_short_links_by_sid(session_id());
?>
<div class="container">
    <h3>Короткие ссылки с этого IP:</h3>
    <?php foreach ($short_link_by_ip as $link): ?>
        <li><?= "<a href=\"https://localhost/go?{$link['short_url']}\">{$link['short_url']}</a>" ?></li>
    <?php endforeach; ?>
</div>
<div class="container">
    <h3>Короткие ссылки с этого SID:</h3>
    <?php foreach ($short_link_by_sid as $link): ?>
        <li><?= "<a href=\"https://localhost/go?{$link['short_url']}\">{$link['short_url']}</a>" ?></li>
    <?php endforeach; ?>
</div>
</body>
</html>
