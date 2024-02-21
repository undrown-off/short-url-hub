<?php

$data_directory = __DIR__ . "data";

// Функция поиска длинной ссылки по короткой ссылке
function find_by_short_link($short_link = '') {
    global $data_directory;
    if(empty($short_link)) {
        return null;
    }
    if (file_exists($data_directory . "short_urls.txt")) {
        $short_urls = file($data_directory . "short_urls.txt", FILE_IGNORE_NEW_LINES);
        if (($key = array_search($short_link, $short_urls)) !== false && isset($short_urls[$key - 1])) {
            return $short_urls[$key - 1];
        }
    }
    return null;
}


// Функция поиска короткой ссылки по длинной ссылке
function find_by_full_link($full_link = '') {
    global $data_directory;
    if(empty($full_link)) {
        return null;
    }
    if (file_exists($data_directory . "short_urls.txt")) {
        $short_urls = file($data_directory . "short_urls.txt", FILE_IGNORE_NEW_LINES);
        if (($key = array_search($full_link, $short_urls)) !== false) {
            return $short_urls[$key + 1];
        }
    }
    return null;
}

// Функция проверки полученной ссылки на существование в именах файлов

//$file_path = '';
//function find_by_short_link($short_link = '') {
//    // проверка полученной ссылки на существование в содержимом файлов
//    return ['short_link' => $short_link,
//            'long link' => 'google.com'];
//}
//
//function find_by_full_link($full_link = '') {
//    // проверка полученной ссылки на существование в именах файлов
//    if($full_link == '')
//        return [];
//    return ['short_link' => 'dasda',
//        'long link' => 'google.com'];
//}

function create_short_link(){
// создание короткой ссылки
    return "http://example.com/" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
}

function save_link($short_link = '', $full_link = ''){
//сохранение ссылки в файл
    global $data_directory;
    if (!file_exists($data_directory)) {
        mkdir($data_directory, 0777, true);
    }
    file_put_contents($data_directory . "short_links.txt", "$full_link\n$short_link\n", FILE_APPEND);
}

// BEGIN
$full_link = $_GET['link'];


//$files = scandir("data");
//$found_entry = find_by_full_link($full_link);

//find_by_short_link("dadadwqeq");


// Создаем короткую ссылку
$short_link = create_short_link();

// Сохраняем ссылку в файл
save_link("https://example.com/full_link", $short_link);

// Ищем длинную ссылку по короткой
$full_link = find_by_short_link($short_link);
echo "Длинная ссылка: $full_link<br>";

// Ищем коротную ссылку по длинной
$short_url = find_by_full_link("https://example.com/long_url");
echo "Короткая ссылка: $short_url";
//$short = create_short_link();
//echo "созданная сылка: $short";
?>