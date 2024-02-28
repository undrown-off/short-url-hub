<?php


// 1. Дана строка, содержащая полное имя файла (например, 'c:\WebServers\home\testsite\www\myfile.txt'). Выделите из этой строки имя файла без расширения.

echo basename('c:\WebServers\home\testsite\www\myfile.txt',".txt").'<br />';

// 2. Дан текст. Найдите в нем все числа, окруженные пробелами, и добавьте перед ними '<' и после них '>'.


$text = "Тестовый текст №1 для проверки 3 строчных 55 функций _5_";
echo preg_replace('/\s(\d+)\s/', ' <$1> ', $text).'<br />';

// 3. Заданное натуральное число от 1 до 1999 вывести римскими цифрами.

function int_roman(int $num): string
{
    $romans = [
        1 => ['1' => 'I', '5' => 'V'],
        2 => ['1' => 'X', '5' => 'L'],
        3 => ['1' => 'C', '5' => 'D'],
        4 => ['1' => 'M'],
    ];

    $stringArr = str_split(strval($num), 1);
    $len       = strlen(strval($num));
    $result    = '';
    for ($i = 1, $pos = $len; $i <= $len; $i++, $pos--) {
        $current = $stringArr[$i - 1];
        if ($current == '0') {
            continue;
        }
        if ($current == '4') {
            $result .= $romans[$pos]['1'] . $romans[$pos]['5'];
        } else if ($current == '9') {
            $result .= $romans[$pos]['1'] . $romans[$pos + 1]['1'];
        } else {
            if (!isset($romans[$pos][$current])) {
                $current < 5 ? $result .= str_repeat($romans[$pos]['1'], $current) : $result .= $romans[$pos]['5'] . str_repeat($romans[$pos]['1'], $current);
            } else {
                $result .= $romans[$pos][$current];
            }
        }
    }
    return $result;
}

echo int_roman(2024) . "<br/>";
echo int_roman(1999) . "<br/>";


// 4. В заданном списке слов найдите самое длинное слово, образованное другими словами, входящими в список. Например, для слов dog, cat, mouse, dogcat, mouseandcat ответом является слово dogcat.

function longest_compound_str(array $words): mixed
{
    $compound_words = [];

    for ($i = 0; $i < count($words); $i++) {
        for ($j = 0; $j < count($words); $j++) {
            if ($words[$i] == $words[$j]) {
                continue;
            }
            if (str_contains($words[$i], $words[$j])) {
                if (!in_array($words[$i], $compound_words)) {
                    array_push($compound_words, $words[$i]);
                }
            }
        }
    }

    $core_words = array_diff($words, $compound_words);

    $valid_compounds = [];
    foreach ($compound_words as $index => $compound) {
        foreach ($core_words as $core) {
            if (str_contains($compound, $core)) {
                $compound = str_replace($core, ".", $compound);
            }
        }
        if ($compound == "..") {
            array_push($valid_compounds, $compound_words[$index]);
        }
    }

    $longest_compound_word = array_reduce($valid_compounds, function ($carry, $word) {return strlen($word) > strlen($carry) ? $word : $carry;}, '');

    return $longest_compound_word;
}


echo "<pre>";
print_r(longest_compound_str(["dog","cat","mousecat","mouse", "dogcat", "mouseandcat", "mouseuuuog", "bird","elephant", "mouseelephant"]));
echo "</pre>";