<?php

require_once ("lib/db.php");
/*
echo "<pre>";
$data = db_fetchAll("SELECT * FROM users");
var_dump($data);
echo "</pre>";


$result = db_execute("INSERT INTO users (name, email) VALUES (?, ?)", ["name", "emm"]);
var_dump($result);




*/

exit();

/**
 * @param $short_link
 * @return bool
 */
function find_short_link($short_link = '')
{
    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . $short_link)) {
        return true;
    }
    return false;
}

/**
 * @param $full_link
 * @return false|mixed
 */
function find_full_link($full_link = '')
{
    $files = array_diff(scandir(__DIR__ . DIRECTORY_SEPARATOR . "data"), array('..', '.', '.gitkeep'));

    foreach ($files as $file) {
        $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . $file);
        if ($content == $full_link)
            return $file;
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

function save_link($short_link = '', $full_link = '')
{
    file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . $short_link, $full_link);
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
    <h1>Your link is:</h1>
    <?="https://{$_SERVER["SERVER_NAME"]}/go.php?{$short_link}"; ?>
</div>
</body>

</html>
