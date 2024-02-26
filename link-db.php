<?php

require_once ("lib/db.php");


/**
 * @param $short_link
 * @return bool
 */
function find_short_link($short_link = '')
{
    if ($data = db_fetchAll("SELECT short_url FROM short_url WHERE short_url=?", [$short_link])) {
        return $data['short_url'];
}
    return false;
}

/**
 * @param $full_link
 * @return false|mixed
 */
function find_full_link($full_link = '')
{
    if ($data = db_fetchAll("SELECT short_url FROM short_url WHERE full_url=?", [$full_link])) {
        return $data [0]["short_url"];
    }
    return false;
}

/**
 * @return false|string
 */
function create_short_link()
{
    $bytes = random_bytes(5);
    return bin2hex($bytes);
}

function save_link($short_link = '', $full_link = '')
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
    <h1>Ваша короткая ссылка</h1>
    <?="https://{$_SERVER["SERVER_NAME"]}/go.php?{$short_link}"; ?>
</div>
</body>

</html>
