<?php
require_once("lib/db.php");


function find_by_short_link($short_link = ''): mixed
{
   $match = db_fetchAll("SELECT full_url FROM short_url WHERE `short_url` = ?",[$short_link]);

   if(!$match){
    return false;
   }else{
    return $match[0]["full_url"];
   }
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


if ($redirect = find_by_short_link($_SERVER["QUERY_STRING"])) {
    header("Location: {$redirect}");
    die();
} else {
    http_response_code(404);
    die();
}