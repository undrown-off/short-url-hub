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
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($permitted_chars), 0, 10);
    }

    /**
     * @param $short_link
     * @param $full_link
     * @return void
     */
    public function save_link($short_link = '', $full_link = '')
    {
        $session_id = session_id();
        if (empty($session_id)) {
            $session_id = "";
        }

        $ip_address = $_SERVER['REMOTE_ADDR'];
        if (empty($ip_address))
            $ip_address = "";
        DbQuery::db_execute("INSERT INTO short_url (short_url, full_url, date_create, ip_address, SID) VALUES (?, ?, ?, ?, ?)", [
            $short_link, $full_link, time(), $ip_address, $session_id
        ]);
    }

    /**
     * @param $ip
     * @return false|array
     */
    public function find_short_links_by_ip($ip = '')
    {
        if ($rows = DbQuery::db_fetchAll("SELECT short_url, date_create FROM short_url WHERE ip_address=?", [$ip])) {
            return $rows;
        }
        return false;
    }

    /**
     * @param $sid
     * @return false|array
     */
    public function find_short_links_by_sid($sid = '')
    {
        if ($rows = DbQuery::db_fetchAll("SELECT short_url, date_create FROM short_url WHERE SID=?", [$sid])) {
            return $rows;
        }
        return false;
    }
}