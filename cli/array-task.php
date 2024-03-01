<?php

//Дан двумерный массив:
$arr = [
    ["a" => 23, "b" => 1],
    ["a" => 14, "b" => 30],
    ["a" => 3,  "b" => 42],
    ["a" => 9,  "b" => 5]
];

//задача: написать метод, "columnSort(&$array, $innerKey = "a")"
//
//который произведет сортировку по возрастанию внешних элементов,
//в зависимости от значения внутреннего массива определенного общего ключа "a" или "b"
//
//пример, если $innerKey = "b":
//то результат будет:
//
//$arr = [
//    ["a" => 23, "b" => 1],
//    ["a" => 9,  "b" => 5],
//    ["a" => 14, "b" => 30],
//    ["a" => 3,  "b" => 42]
//];
function columnSort(&$array, $innerKey = "a") {
    $sortArray = array_column($array, $innerKey);
    array_multisort($sortArray, $array);
}


columnSort($arr, "a");
echo "<pre>";
print_r($arr);
echo "</pre>";