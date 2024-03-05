<?php

class Errors
{

    private static $allow_codes = [404, 500];

    /**
     * @param $code
     * @param $message
     * @return void
     */
    private static function error_x($code = 404, $message = "Page not found")
    {
        http_response_code($code);
        exit($message);
    }

    /**
     * @param $name
     * @param $args
     * @return void
     */
    public static function __callStatic($name = "", $args = [])
    {
        $code = str_replace("code_", "", $name);

        if (in_array($code, self::$allow_codes) && !empty($args)) {
            self::error_x($code, $args[0]);
        } else {
            exit("__callStatic method not allowed");
        }
    }


}