<?php

// Запрос данных у пользователя
echo "Введите ваше имя: ";
$name = readline(); // Считываем введенное имя пользователя

echo "Введите ваш возраст: ";
$age = readline(); // Считываем введенный возраст пользователя

// Проверка типов данных и преобразование
if (!is_numeric($age)) { // Проверяем, является ли возраст числом
    echo "Ошибка: Возраст должен быть числом.\n";
    exit(); // Прекращаем выполнение программы
}

$age = intval($age); // Преобразуем возраст в целое число

echo "Введите ваш email: ";
$email = readline(); // Считываем введенный email пользователя

// Создание объекта с данными пользователя
$userData = new stdClass();
$userData->name = $name;
$userData->age = $age;
$userData->email = $email;

// Создание массива с данными пользователя
$userDataArray = [];
$userDataArray['name'] = $name;
$userDataArray['age'] = $age;
$userDataArray['$email'] = $email;

// Вывод данных пользователя на экран
echo "\nСпасибо! Вот информация, которую вы ввели:\n";
echo "Имя: {$userData->name}\n";
echo "Возраст: {$userData->age}\n";
echo "Email: {$userData->email}\n";

