<?php
if (isset($parse_url["query"])) {
    parse_str($parse_url["query"], $parse_str);
} else {
    Errors::code_500("query not found");
}

if (!isset($parse_str['link'])) {
    Errors::code_500("link not found");
}

if (!is_string($parse_str['link'])) {
    Errors::code_500("link is not string");
}

$url = new Url();
$ip = $_SERVER['REMOTE_ADDR'];
$sid = session_id();
$input_data = $parse_str['link'];
$short_link = $url->find_full_link($input_data);
if (!$short_link) {
    for (; ;) {
        $short_link = $url->create_short_link();
        if (!$url->find_short_link($short_link)) {
            $url->save_link($short_link, $input_data, $ip, $sid);
            break;
        }
    }
}
$shor_link_by_ip = $url->find_short_links_by_ip($ip);
$short_link_by_sid = $url->find_short_links_by_sid($sid);
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
<div class="container">
    <h3>Короткие ссылки с этого IP:</h3>
    <?php foreach ($shor_link_by_ip as $link): ?>
        <li><?= $link['short_url'] ?></li>
    <?php endforeach; ?>
</div>
<div class="container">
    <h3>Короткие ссылки с этого SID:</h3>
    <?php foreach ($short_link_by_sid as $link): ?>
        <li><?= $link['short_url'] ?></li>
    <?php endforeach; ?>
</div>
</body>

</html>