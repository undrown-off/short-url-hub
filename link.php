<?php
function find_by_short_link($short_link = ''): string | bool
{
    // проверка полученной ссылки на существование в именах файлов
    $folderPath = "data";
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
    $folderPath = "data";
    $files      = scandir($folderPath);

    if ($full_link) {
        $search_content = function ($i = 0) use ($files, $full_link, $folderPath, &$search_content) {
            for ($i; $i < count($files); $i++) {
                $file = $files[$i];

                if ($file !== '.' && $file !== '..') {
                    $filePath    = $folderPath . '/' . $file;
                    $fileContent = file_get_contents($filePath);

                    if ($fileContent === $full_link) {
                        echo "Эта ссылка уже находится в базе </br>";
                        print_r($filePath . ": " . $fileContent);
                        return $filePath;
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

function save_link($short_link = '', $full_link = '')
{
    // сохранение ссылки в файл

    if ($short_link && $full_link) {
        if (!find_by_short_link($short_link) && !find_by_full_link($full_link)) {
            $filePath = "data/{$short_link}.txt";
            file_put_contents($filePath, $full_link, LOCK_EX);
        }

    }

}

function get_full_link(): string
{
    if (isset($_GET['link'])) {
        $input_full_link = $_GET['link'];

    }
    return $input_full_link;

}

function render_full(string $link): string
{
    return "<a href=\"{$link}\" target=\"_blank\">{$link}</a><br />";
}

function render_short(string $link, string $visibleLink): string
{
    return "<a href=\"{$link}\" target=\"_blank\">https://{$visibleLink}</a><br />";
}

// TODO

echo "Your long link is: " . render_full(get_full_link());
echo "Your short link is: " . render_short(get_full_link(), create_short_link(10)) . "<br />";

save_link(create_short_link(10), get_full_link());