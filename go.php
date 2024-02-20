<?php
function find_short_link($short_link = '')
{
    $file_name = __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . $short_link;
    if (file_exists($file_name)) {
        return file_get_contents($file_name);
    }
    return false;
}


if (!isset($_SERVER["QUERY_STRING"])) {
    http_response_code(404);
    die();
} else {
    if (empty($_SERVER["QUERY_STRING"])) {
        http_response_code(404);
        die();
    }
}


if ($redirect = find_short_link($_SERVER["QUERY_STRING"])) {
    header("Location: {$redirect}");
    die();
} else {
    http_response_code(404);
    die();
}