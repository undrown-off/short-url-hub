<?php
if (isset($parse_url["query"])) {
    parse_str($parse_url["query"], $parse_str);
} else {
    error_500("query not found");
}

if (!isset($parse_str['link'])) {
    error_500("link not found");
}

if (!is_string($parse_str['link'])) {
    error_500("link is not string");
}

// ==================== RUN ========================

$full_link = $parse_str['link'];
$found_link = found_by_full_link($full_link);


$output_messsage = $found_link ? "Эта ссылка уже находится в базе -- {$found_link['short_url']}</br> Дата
добавления: {$found_link['date_create']}</br>" : false;

$random_link = create_short_link(10);

$short_link = $found_link["short_url"] ?? get_meaningful_shortlink($full_link) . $random_link ;

$short_link_no_scheme = $found_link["short_url"] ?? get_meaningful_shortlink($full_link, "NO_SCHEME") . $random_link;

save_link($short_link_no_scheme, $full_link);


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
          <?php echo "Your short link is: " . render_redirect($short_link_no_scheme) . "<br />"; 
                    ?>
        </div>
      </div>
    </div>
  </main>
</body>

</html>