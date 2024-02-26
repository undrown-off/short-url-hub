<?php

require_once ("lib/db.php");


/**
 * @param $short_link
 * @return bool
 */
function find_short_link($short_link = '')
{
    $data = db_fetchAll("SELECT short_url FROM short_url" );
    foreach ($data as $item) {
        if ($item['short_url'] == $short_link) {
            return $item['short_url'];
        }
    }

    return false;
}

/**
 * @param $full_link
 * @return false|mixed
 */
function find_full_link($full_link = '')
{
    $data = db_fetchAll("SELECT short_url, full_url FROM short_url");
    foreach ($data as $item) {
        if ($item['full_url'] == $full_link) {
            return $item['short_url'];
        }
    }
    return false;
}

/**
 * @return false|string
 */
function create_short_link()
{
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($permitted_chars), 0, 10);
}

function save_link($short_link = '', $full_link = '', $datecreate = '')
{
    db_execute("INSERT INTO short_url (short_url, full_url, date_create)
                      VALUES (?, ?, ?)", [$short_link, $full_link, time()]);
}


//*****************************************************************************************

if (!isset($_GET['link']))
    exit("'link' not found");

$input_data = $_GET['link'];
$short_link = find_full_link($input_data);
if (!$short_link) {
    for (; ;) {
        $short_link = create_short_link();
        if (!find_short_link($short_link)) {
            save_link($short_link, $input_data, time());
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
    <?="https://{$_SERVER["SERVER_NAME"]}/go.php?{$short_link}"; ?>
</div>
</body>

</html>
