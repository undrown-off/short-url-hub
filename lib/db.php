<?php

/****************************/
/* Настройки подключания    */
/****************************/

const DB_NAME = "my_db3";
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";


/****************************/
/* Функции для работы с БД */
/***************************/

/**
 * @return PDO
 */
function db_connect()
{
    $connection = new \PDO(
        'mysql:dbname=' . DB_NAME . ";host=" . DB_HOST . ";port=3306;charset=utf8;",
        DB_USER,
        DB_PASS);

    $stmt = $connection->prepare("SET sql_mode=?");
    $stmt->execute([implode(',', [
        'NO_ZERO_IN_DATE',
        'NO_ZERO_DATE',
        'ERROR_FOR_DIVISION_BY_ZERO',
        'NO_AUTO_CREATE_USER',
        'NO_ENGINE_SUBSTITUTION'
    ])]);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $connection;
}


/**
 * @param $query
 * @param $holders
 * @return false|PDOStatement|void
 */
function db_execute($query, $holders = [])
{
    $connection = db_connect();
    $stmt = $connection->prepare($query);

    try {
        if (!empty($holders)) {

            foreach ($holders as $key => $value) {

                if (is_int($value))
                    $param = PDO::PARAM_INT;
                elseif (is_float($value))
                    $param = PDO::PARAM_STR;
                elseif (is_bool($value))
                    $param = PDO::PARAM_BOOL;
                elseif (is_null($value))
                    $param = PDO::PARAM_NULL;
                elseif (is_string($value))
                    $param = PDO::PARAM_STR;
                else
                    $param = false;

                $paramNumber = $key + 1;

                if ($param !== false) {
                    $stmt->bindValue(
                        (is_string($key)
                            ? $key
                            : $paramNumber), $value, $param);
                }

            }
        }

        $stmt->execute();

    } catch (Exception $e) {
        exit($e->getMessage());
    }

    return $stmt;
}

/**
 * @param $query
 * @param $arguments
 * @return array|false
 */
function db_fetchAll($query, $arguments = [])
{
    $stmt = db_execute($query, $arguments);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}