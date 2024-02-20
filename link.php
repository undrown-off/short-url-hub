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
//            echo "File: $filePath\n";
//            echo "Content: $content";
            if (strpos($content, $full_link) !== false) {
                return $file;
            }
        }
    }
    return false;
}

function create_short_link() {
    $bytes = random_bytes(5);
    $short_link = bin2hex($bytes);
    return $short_link;
}

function save_link($short_link = '', $full_link = '') {
    $filePath = "data/{$short_link}.txt";
    file_put_contents($filePath, $full_link, LOCK_EX);
}




function get_full_link() {
    $full_link = isset($_GET['link']) ? trim($_GET['link']) : null;
    return $full_link;
}

// BEGIN
$full_link = get_full_link();

$short_link = find_by_full_link($full_link);
echo "короткая ссылка $short_link";

