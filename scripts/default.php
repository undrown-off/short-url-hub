<?php 
$url = new Url();

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

      <div class="app__title">Введите свою ссылку ниже -
        и мы создадим для вас короткую версию,
        которую легко передать другу:</div>

      <form method="get" class="app__form" action="/create">
        <input type="url" name="link" placeholder="https://example.com" required>
        <input type="submit" value="Создать ссылку">
      </form>

      <div class="app__output-show-table">Показать детали: </div>
      <div class="app__output-links-container">
      <div class="app__output-links">
        <div class="app__output-links-title">С этого ip адреса были запрошены следующие ссылки:</div>
        <div class="app__output-links-ip-links">
          <table class='app__output-links-table'>
            <?php foreach ($short_links_ip as $short_link) {
                $short_link_rendered = $url->render_short($short_link['full_url'],$short_link['short_url']);
                $short_link_ip = $short_link['ip_address'];
                $date = $short_link['date_create'];
                echo 
                "
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
      <div class="app__output-links">
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