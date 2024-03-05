<?php

/*******************************/
/* библиотека для работы с БД */
/******************************/

class DbQuery extends DbBase
{

    /**
     * @param $query
     * @param $arguments
     * @return array|false
     */
    public static function db_fetchAll($query, $arguments = [])
    {
        $stmt = parent::db_execute($query, $arguments);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $query
     * @param $arguments
     * @return array|false
     */
    public static function db_fetch($query, $arguments = [])
    {
        $stmt = parent::db_execute($query, $arguments);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}