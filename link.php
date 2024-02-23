<?php

define("SLASH", DIRECTORY_SEPARATOR);

function find_by_short_link($short_link = ''): string | bool
{
    // проверка полученной ссылки на существование в именах файлов

    $folderPath = __DIR__ . SLASH ."data";
    $files      = scandir($folderPath);
    if ($short_link) {
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                if ($file == $short_link) {
                    return $folderPath . '/' . $file;
                } else {
                    return false;
                }
            }
        }
    }
}

function find_by_full_link($full_link = ''): string | bool
{
    //     проверка полученной ссылки на существование в содержимом файлов
    $folderPath = __DIR__ . SLASH ."data";
    $files      = scandir($folderPath);

    if ($full_link) {
        $search_content = function ($i = 0) use ($files, $full_link, $folderPath, &$search_content) {
            for ($i; $i < count($files); $i++) {
                $file = $files[$i];
                if ($file !== '.' && $file !== '..') {
                    $filePath    = $folderPath . SLASH . $file;
                    $fileContent = file_get_contents($filePath);

                    if ($fileContent === $full_link) {

                        return "Эта ссылка уже находится в базе -- filepath: {$filePath}</br> file-content:  {$fileContent}</br>";
                    } else {
                        $result = $search_content($i + 1);

                        if ($result !== false) {
                            return $result;
                        }
                    }
                }
            }
            return false;
        };
        return $search_content();
    }
    return false;
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
    $deleteVowels = "/(?<=[^aAEeIiUuOoYy])[aAEeIiUuOoYy]/";
    $noVowelStr   = preg_replace($deleteVowels, "", $domain);
    if ($flag == 'NO_SCHEME') {
        return "{$noVowelStr}";
    } else {
        return "{$scheme}://{$noVowelStr}";
    }

}

function save_link($short_link = '', $full_link = '')
{
    // сохранение ссылки в файл

    if ($short_link && $full_link) {
        if (!find_by_short_link($short_link) && !find_by_full_link($full_link)) {
            $filePath =  __DIR__ . SLASH . "data/{$short_link}.txt";
            file_put_contents($filePath, $full_link, LOCK_EX);
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


function render_full(string $full_link): string
{
    return "<a href=\"{$full_link}\" target=\"_blank\">{$full_link}</a><br />";
}

function render_short(string $full_link, string $visibleLink): string
{
    return "<a href=\"{$full_link}\" target=\"_blank\">{$visibleLink}</a><br/>";
}
function render_redirect(string $full_link, string $visibleLink){
    return "<a href=\"https://{$_SERVER["SERVER_NAME"]}/go.php?{$full_link}\">{$visibleLink}</a><br/>";
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

            <div class="app__output">
                <div class="app__output-message">
                    <?php echo $output_messsage; ?>
                </div>
                <div class="app__output-full">

                    <?php echo "Your long link is: " . render_full($full_link); ?>
                </div>
                <div class="app__output-short">
                    <?php 
                    // echo "Your short link is: " . render_short($full_link, $short_link) . "<br />"; 
                    ?>
                    <?php echo "Your short link is: " . render_redirect($full_link,$short_link) . "<br />"; ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>