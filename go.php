<?php

require_once ("lib/db.php");
function find_short_link($short_link = '')
{
    if ($data = db_fetchAll("SELECT short_url FROM short_url WHERE short_url=?", [$short_link])) {
        return $data ["full_link"];
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
} else {
    http_response_code(404);
}
die();