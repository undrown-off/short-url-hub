<?php


class Errors{

public static function __callStatic($name, $message){

}


 private static function code_404($message = "Page not found"){
    http_response_code(404);
    exit($message);
}


private static function code_500($message = "Internal server error"){
    http_response_code(500);
    exit($message);
}
}