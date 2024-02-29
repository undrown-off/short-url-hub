<?php

/**
 * @param $array
 * @param $key
 * @return void
 */
function columnSort(&$array, $key = "id")
{
    uasort($array, function ($a, $b) use ($key) {
        return ($a[$key] > $b[$key]);
    });
}

$arr = [
    ["a" => 23, "b" => 1],
    ["a" => 14, "b" => 30],
    ["a" => 3,  "b" => 42],
    ["a" => 9,  "b" => 5]
];

columnSort($arr, "a");
print_r($arr);

columnSort($arr, "b");
print_r($arr);