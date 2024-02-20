<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Short-url-hub</title>
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
<p>Введите свою ссылку ниже и мы создадим для вас короткую версию, которую легко передать другу</p>
<form action="link.php" method="get" onsubmit="return validateForm()">
    <form>
        <label for="textInput">Введи ссылку:</label>
        <input type="text" id="textInput" name="link">
        <input type="submit" value="Получить короткую ссылку">
    </form>
</form>
</body>
</html>
