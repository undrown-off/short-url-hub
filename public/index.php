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


function autoloader($classname = "")
{
if (file_exists(DIR_ROOT . "lib" . DS . $classname . ".php")) {
require_once(DIR_ROOT . "lib" . DS . $classname . ".php");
} else {
die("Class {$classname} not found");
}
}

spl_autoload_register("autoloader");


/* подключение скрипта */
if (file_exists(DIR_ROOT . "scripts" . DS . $file)) {
require_once(DIR_ROOT . "scripts" . DS . $file);
} else {
Errors::code_500("file not found: {$file}");
}


/*
*  затраты ресурсов
*
echo "<pre>";
print_r(get_included_files());
echo memory_get_peak_usage() / 1024;
echo " KB";
echo "</pre>";
*/