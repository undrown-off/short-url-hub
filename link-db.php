<?php

require_once("lib/db.php");


function parse_data(array $data):mixed{
    return [
        "short_url" => $data[0]["short_url"],
        "full_url" => $data[0]["full_url"],
        "date_create" => $data[0]["date_create"],
    ];
}

function found_by_short_link($short_link = ''): array |bool
{
   $data = db_fetchAll("SELECT * FROM short_url WHERE `short_url` = ?",[$short_link]);
    if($short_link){
        if(!$data){
            return false;
           }else{
            return parse_data($data);
           }
    }
   
}

function found_by_full_link($full_link = ''): array |bool
{
    $data = db_fetchAll("SELECT * FROM short_url WHERE `full_url` = ?",[$full_link]);
    
    if ($full_link) {
        if (!$data) {
            return false;
        } else {
            return parse_data($data);
        }
    }
}

                

function create_short_link(int $length): string
{
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
    if ($short_link && $full_link) {
        if (!found_by_short_link($short_link) && !found_by_full_link($full_link)) {
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


function render_full(string $full_link): string
{
    return "<a href=\"{$full_link}\" target=\"_blank\">{$full_link}</a><br />";
}

function render_short(string $full_link, string $visibleLink): string
{
    return "<a href=\"{$full_link}\" target=\"_blank\">{$visibleLink}</a><br/>";
}

function render_redirect(string $short_link_no_scheme){
    return "<a href=\"https://{$_SERVER["SERVER_NAME"]}/go.php?{$short_link_no_scheme}\">{$short_link_no_scheme}</a><br/>";
}

// ==================== RUN ========================

$full_link = get_full_link();

$found_link = found_by_full_link($full_link)?? false;

$output_messsage = $found_link ? "Эта ссылка уже находится в базе -- {$found_link['short_url']}</br> Дата
добавления: {$found_link['date_create']}</br>" : false;

$random_link = create_short_link(10);

$short_link = $found_link["short_url"] ?? get_meaningful_shortlink($full_link) . $random_link ;

$short_link_no_scheme = $found_link["short_url"] ?? get_meaningful_shortlink($full_link, "NO_SCHEME") . $random_link;


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
                    <?php 
                    // echo "Your short link is: " . render_short($full_link, $short_link) . "<br />"; 
                    ?>
                    <?php echo "Your short link is: " . render_redirect($short_link_no_scheme) . "<br />"; 
                    echo $short_link_no_scheme;
                    ?>

                </div>
            </div>
        </div>
    </main>
</body>

</html>