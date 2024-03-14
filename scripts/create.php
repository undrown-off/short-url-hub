<?php
if (isset($parse_url["query"])) {
    parse_str($parse_url["query"], $parse_str);
} else {
    Errors::code_500("query not found");
}

if (!isset($parse_str['link'])) {
    Errors::code_500("link not found");
}

if (!is_string($parse_str['link'])) {
    Errors::code_500("link is not string");
}

// ==================== RUN ========================

$url = new Url();

$full_link  = $parse_str['link'];
$found_link = $url->found_by_full_link($full_link);

$output_messsage = $found_link ? "Эта ссылка уже находится в базе -- {$found_link['short_url']}</br> Дата
добавления: {$found_link['date_create']}</br>" : false;

$random_link = $url->create_short_link(10);

$short_link = $found_link["short_url"] ?? $url->get_meaningful_shortlink($full_link) . $random_link;

$short_link_no_scheme = $found_link["short_url"] ?? $url->get_meaningful_shortlink($full_link, "NO_SCHEME") . $random_link;

$url->save_link($short_link_no_scheme, $full_link);

$short_links_ip  = $url->find_short_links_by_ip($_SERVER['REMOTE_ADDR']);
$short_links_sid = $url->find_short_links_by_sid(session_id());


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
      <div class="app__title">Ваша новая ссылка :</div>
      <div class="app__home">
        <a href="/">
          <?echo file_get_contents("./assets/images/home.svg") ?></a>
      </div>
      <div class="app__output">
        <div class="app__output-message">
          <?php echo $output_messsage; ?>
        </div>
        <div class="app__output-full">

          <?php echo "Ваша полная ссылка: " . $url->render_full($full_link); ?>
        </div>
        <div class="app__output-short">

          <?php echo "Ваша короткая ссылка: " . $url->render_redirect($short_link_no_scheme);?>
          <button class="copy-btn">copy</button>
        </div>
        <div class="app__output-links active">
          <div class="app__output-links-title">С этого ip адреса были запрошены следующие ссылки:</div>
          <div class="app__output-links-ip-links">
            <table class='app__output-links-table'>
              <?php foreach ($short_links_ip as $short_link) {
                $short_link_rendered = $url->render_short($short_link['full_url'],$short_link['short_url']);
                $short_link_ip = $short_link['ip_address'];
                $date = $short_link['date_create'];
                echo "
                <tr>
                    <td class='app__output-links-ip-shortlink'>{$short_link_rendered}</td>
                    <td class='app__output-links-ip'>{$short_link['ip_address']}</td>
                    <td class='app__output-links-ip-date'>{$date}</td>
                  </tr>
                ";
                }
                ?>
            </table>
          </div>
        </div>
        <div class="app__output-links active">
          <div class="app__output-links-title">Для текущей сессии были запрошены следующие ссылки:</div>
          <div class='app__output-links-sid-links'>
            <table class='app__output-links-table'>
              <?php
              foreach ($short_links_sid as $short_link) {
                  $short_link_rendered = $url->render_short($short_link['full_url'],$short_link['short_url']);
                  $short_link_sid = $short_link['s_id'];
                  $date = $short_link['date_create'];
                  echo 
                  "
                  <tr>
                    <td class='app__output-links-sid-shortlink'>{$short_link_rendered}</td>
                    <td class='app__output-links-sid'>{$short_link_sid}</td>
                    <td class='app__output-links-sid-date'>{$date}</td>
                  </tr>
                ";
                }
                ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="main.js"></script>

</body>

</html>