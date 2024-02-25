<?php

/**************************************/
/*  библиотека для работы с ссылками  */
/**************************************/

function find_short_link($short_link = '')
{
    if ($row = db_fetch("SELECT full_url FROM short_url WHERE short_url=?", [$short_link])) {
        return $row["full_url"];
    }
    return false;
}

/**
 * @param $full_link
 * @return false|mixed
 */
function find_full_link($full_link = '')
{
    if ($row = db_fetch("SELECT short_url FROM short_url WHERE full_url=?", [$full_link])) {
        return $row["short_url"];
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

/**
 * @param $short_link
 * @param $full_link
 * @return void
 */
function save_link($short_link = '', $full_link = '')
{
    db_execute("INSERT INTO short_url (short_url, full_url, date_create) VALUES (?, ?, ?)", [
        $short_link, $full_link, time()
    ]);
}
