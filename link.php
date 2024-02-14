<?php
function find_by_short_link($short_link = '')
{
    //     проверка полученной ссылки на существование в содержимом файлов
//    return [
//        'short_link'=> $short_link,
//        'long_link'=> "slkjf" ];
}





function find_by_full_link($full_link = '') {
    // проверка полученной ссылки на существование в именах файлов
}

function create_short_link() {
    // создание короткой ссылки
}

function save_link($short_link = '', $full_link = '') {
    // сохранение ссылки в файл
}
//function save_link($short_link = '', $full_link = ''): {
//    // сохранение ссылки в файл
//}

// BEGIN
$input_full_link = $_GET['link'];

// TODO

echo "Your link is: <br>
/go.php/ksjdhfkjas <br>" ;
echo "Your long link is {$input_full_link}";