<?php
// require_once("lib/db.php");


// // $test = db_execute("INSERT INTO short_url (`short_url`, `full_url`,`date_create`) VALUES ('https://www.dgfhhgfhfgh/', 'https://www.gismeteo.md/weather-tiraspol-4981/', NOW())");

// $short_link = "https://www.gism";
// $full_link  = "https://www.gismeteo.md/weather-tiraspol-4981/";
// $d = date("Y-m-d");

// db_execute("INSERT INTO short_url (short_url,full_url,date_create) VALUES(?,?,?)",[$short_link, $full_link, $d ]);


// function find_by_short_link($short_link = ''):mixed
// {

// //    $data = db_fetchAll("SELECT * FROM short_url WHERE short_url = ?",[$short_link]);
// $data = db_fetchAll("SELECT * FROM short_url");
//    if(!$data){
//     return false;
//    }else{
//     return $data;
//     // return "Эта ссылка уже находится в базе -- : {$data[0]['short_url']}</br> Дата добавления: {$data[0]['date_create']}";
//    }
// }


// echo "<pre>";

// $sl = find_by_short_link("https://www.dgfhhgfhfgh/");
// print_r($sl);
// echo "</pre>";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicons/favicon-16x16.png">
    <link rel="stylesheet" href="assets/style/style.css">
    <title>short-url-hub</title>
</head>


<body>
    <div class="bg-name">short-url-hub</div>
    <main class="app">
        <div class="app__inner">


            <div class="app__title">Введите свою ссылку ниже -
                и мы создадим для вас короткую версию,
                которую легко передать другу:</div>

            <form class="app__form" action="link-db.php">
                <input type="url" name="link" placeholder="https//example.com" required>
                <input type="submit" value="send">
            </form>


        </div>
    </main>
</body>

</html>