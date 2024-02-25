<?php
if (isset($parse_url["query"])) {
    parse_str($parse_url["query"], $parse_str);
} else {
    error_500("query not found");
}

if (!isset($parse_str['link'])) {
    error_500("link not found");
}

if (!is_string($parse_str['link'])) {
    error_500("link is not string");
}

$input_data = $parse_str['link'];
$short_link = find_full_link($input_data);
if (!$short_link) {
    for (; ;) {
        $short_link = create_short_link();
        if (!find_short_link($short_link)) {
            save_link($short_link, $input_data);
            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Сервис коротких ссылок</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
<div class="container">
    <h1>Your link is:</h1>
    <a href="<?= "https://{$_SERVER["SERVER_NAME"]}/go?{$short_link}"; ?>"><?= "https://{$_SERVER["SERVER_NAME"]}/go?{$short_link}"; ?></a>
</div>
</body>

</html>
