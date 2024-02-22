<?php

define("SLASH", DIRECTORY_SEPARATOR);
require_once("lib/db.php");


function find_by_short_link($short_link = ''): mixed
{
    // проверка полученной ссылки на существование в базе данных
   $data = db_fetchAll("SELECT * FROM short_url WHERE `short_url` = ?",[$short_link]);

   if(!$data){
    return false;
   }else{
    return $data[0]["short_url"];
   }
}

function find_by_full_link($full_link = ''): mixed
{
    //     проверка полученной ссылки на существование в БД
    $data      = db_fetchAll("SELECT * FROM short_url WHERE `full_url` = ?",[$full_link]);

    
    if ($full_link) {
        if (!$data) {
            return false;
        } else {
            return "Эта ссылка уже находится в базе --  {$data[0]['short_url']}</br> Дата добавления:  {$data[0]['date_create']}</br>";
           
        }
    }
}

                

function create_short_link(int $length): string
{
    // создание короткой ссылки
    $random_bytes = random_bytes(5);
    $hex_link     = bin2hex($random_bytes);
    $hash         = hash('sha256', $hex_link);

    $shortLink = substr($hash, 0, $length);
    return $shortLink;
}

function get_meaningful_shortlink(string $full_link, null | string $flag = null): string
{

    $host   = parse_url($full_link, PHP_URL_HOST);
    $scheme = parse_url($full_link, PHP_URL_SCHEME);
    if (str_contains($host, 'www')) {
        $domain = explode(".", $host)[1];
    } else {
        $domain = explode(".", $host)[0];
    }
    $deleteVowels = "/(?<=[^aAEeIiUuOoYy])[aAEeIiUuOoYy]?/";
    $noVowelStr   = preg_replace($deleteVowels, "", $domain);
    if ($flag == 'NO_SCHEME') {
        return "{$noVowelStr}";
    } else {
        return "{$scheme}://{$noVowelStr}";
    }

}

function save_link($short_link = '', $full_link = '')
{
    // сохранение ссылки в БД

    if ($short_link && $full_link) {
        if (!find_by_short_link($short_link) && !find_by_full_link($full_link)) {
            $d = date("Y-m-d");
            db_execute("INSERT INTO short_url (short_url,full_url,date_create) VALUES(?,?,?)",[$short_link, $full_link, $d ]);
        }
    }

}

function get_full_link(): string
{
    if (!isset($_GET['link'])) {
        exit("link not found");
    } else {
        return $_GET['link'];
    }
}


function render_full(string $link): string
{
    return "<a href=\"{$link}\" target=\"_blank\">{$link}</a><br />";
}

function render_short(string $link, string $visibleLink): string
{
    return "<a href=\"{$link}\" target=\"_blank\">{$visibleLink}</a><br/>";
}

// ==================== RUN ========================

$full_link            = get_full_link();
$output_messsage      = find_by_full_link($full_link);
$random_link          = create_short_link(10);
$short_link           = get_meaningful_shortlink($full_link) . $random_link;
$short_link_no_scheme = get_meaningful_shortlink($full_link, "NO_SCHEME") . $random_link;

save_link($short_link_no_scheme, $full_link);





?>


<!-- ==================== PAGE ================= -->

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
            <div class="app__title">Ваша новая ссылка :</div>
            <div class="app__home">
                <a href="index.php">
                    <? echo file_get_contents("./assets/images/home.svg") ?></a>
            </div>
            <div class="app__output">
                <div class="app__output-message">
                    <?php echo $output_messsage; ?>
                </div>
                <div class="app__output-full">

                    <?php echo "Your long link is: " . render_full($full_link); ?>
                </div>
                <div class="app__output-short">
                    <?php echo "Your short link is: " . render_short($full_link, $short_link). "<br />"; ?>
                </div>
            </div>


        </div>
    </main>
</body>

</html>