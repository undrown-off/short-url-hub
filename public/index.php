<?php

if (!isset($_SERVER["REQUEST_URI"]))
    die();

const DS = DIRECTORY_SEPARATOR;
const DIR_ROOT = __DIR__ . DS . ".." . DS;

/* парсинг запроса */
$parse_url = parse_url($_SERVER["REQUEST_URI"]);

/* маршрутизация */
if ($parse_url["path"]) {
    switch ($parse_url["path"]) {

        case "/":
            $file = "default.php";
            break;

        case "/create":
            $file = "create.php";
            break;

        case "/go":
            $file = "go.php";
            break;

        default:
            $file = "404.php";
    }
} else {
    die();
}

spl_autoload_register("indexAutoloader");

function indexAutoloader($className)
{
    $classDir = DIR_ROOT . 'lib' . DS;
    $classFile = $classDir . $className . '.php';

    if(file_exists($classFile)){
        require_once($classFile);
    }else{
        Errors::code_500("Class file not found for: {$className}");
    }
}


if (file_exists(DIR_ROOT . "scripts" . DS . $file)) {
    require_once DIR_ROOT . "scripts" . DS . $file;
} else {
    Errors::code_500("file not found: {$file}");
}