<?php
if (isset($_GET["id"])) {
    $short_name = $_GET["id"];
    if (file_exists("data/$short_name")) {
        $url = file_get_contents("data/$short_name");
        header("Location: $url");
        exit();
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена";
    }
}
?>
