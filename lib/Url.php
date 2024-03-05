<?php

/**************************************/
/*  библиотека для работы с ссылками  */

/**************************************/

class Url
{

    public function find_short_link($short_link = '')
    {
        if ($row = DbQuery::db_fetch("SELECT full_url FROM short_url WHERE short_url=?", [$short_link])) {
            return $row["full_url"];
        }
        return false;
    }

    /**
     * @param $full_link
     * @return false|mixed
     */
    public function find_full_link($full_link = '')
    {
        if ($row = DbQuery::db_fetch("SELECT short_url FROM short_url WHERE full_url=?", [$full_link])) {
            return $row["short_url"];
        }

        return false;
    }

    /**
     * @return false|string
     */
    public function create_short_link()
    {
        $bytes = random_bytes(5);
        return bin2hex($bytes);
    }

    /**
     * @param $short_link
     * @param $full_link
     * @return void
     */
    public function save_link($short_link = '', $full_link = '')
    {
        DbQuery::db_execute("INSERT INTO short_url (short_url, full_url, date_create) VALUES (?, ?, ?)", [
            $short_link, $full_link, time()
        ]);
    }

}