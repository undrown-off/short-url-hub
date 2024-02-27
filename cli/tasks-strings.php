<?php
/*
1. Дана строка, содержащая полное имя файла (например, 'c:\WebServers\home\testsite\www\myfile.txt').
Выделите из этой строки имя файла без расширения.
*/
$string = 'c:\WebServers\home\testsite\www\myfile.txt';
$string_arr = explode("\\", $string);
$string_arr = explode(".", end($string_arr));
echo "Task 1: ";
echo reset($string_arr);
echo PHP_EOL;

/*
2. Дан текст. Найдите в нем все числа, окруженные пробелами, и добавьте перед ними '<' и после них '>'.
*/
$string = 'Web8ServersWe 98 versWebServe98rServS 88 erve 4444 rsServrve 7 bServers';
echo "Task 2: ";
echo preg_replace("~ ([0-9]+) ~", '< \\1 >', $string);
echo PHP_EOL;

/*
3. Заданное натуральное число от 1 до 1999 вывести римскими цифрами.
тесты, https://findhow.org/5149-konverter-rimskih-tsifr.html
*/

function numberToRoman($number = 0)
{
    $map = [
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100,
        'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10,
        'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
    ];
    $result = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $result .= $roman;
                break;
            }
        }
    }
    return $result;
}
echo "Task 3: ";
echo numberToRoman(1999);
echo PHP_EOL;

/*
4. В заданном списке слов найдите самое длинное слово, образованное другими словами, входящими в список.
Например, для слов dog, cat, mouse, dogcat, mouseandcat ответом является слово dogcat.
*/

$string = 'dog, cat, mouse, dogcat, mousecatdog, mousedogg, mouseccatdog';
$result_word = "";
$result_word_length = 0;

$dictionary = explode(", ", $string);
foreach ($dictionary as $word) {

    $max = 0;
    $length = strlen($word);

    foreach ($dictionary as $word2) {
        if (strpos($word, $word2) !== false && $word != $word2) {
            $length -= strlen($word2);
            $max += strlen($word2);
        }
    }

    if ($length == 0 && $max > $result_word_length) {
        $result_word_length = $max;
        $result_word = $word;
    }
}

echo "Task 4: ";
echo $result_word;
echo PHP_EOL;