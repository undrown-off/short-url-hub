<pre>
<?php
function find_by_short_link($short_link) {
    $folderPath = "data";
    $files = scandir($folderPath);

    if ($short_link) {
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                if ($file == $short_link) {
                    return $folderPath . '/' . $file;
                }
            }
        }
    }
    return false;
}

function find_by_full_link($full_link = '') {

    $folderPath = "data";
    $files = scandir($folderPath);

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filePath = $folderPath . '/' . $file;
            $content = file_get_contents($filePath);
            if (strpos($content, $full_link) !== false) {
                return $file;
            }
        }
    }
    return false;
}

function create_short_link() {
    $bytes = random_bytes(5);
    return bin2hex($bytes);
}

function save_link($short_link = '', $full_link = '') {
    $filePath = "data/{$short_link}";
    file_put_contents($filePath, $full_link, LOCK_EX);
}




function get_full_link() {
    return isset($_GET['link']) ? trim($_GET['link']) : null;
}

// BEGIN
$full_link = get_full_link();
$existingShortLink = find_by_full_link($full_link);

if ($existingShortLink) {
       echo "Ваша короткая ссылка: " . $existingShortLink;
    exit;
}
$shortLink = create_short_link();
while (file_exists("data/{$shortLink}")) {
    $shortLink = create_short_link();
}
save_link($shortLink, $full_link);
echo "Ваша короткая ссылка: " . $shortLink;
