<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Сервис коротких ссылок</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
<div class="container">
    <h1>Сервис коротких ссылок</h1>
    <blockquote>
        Введите свою ссылку ниже и мы создадим для вас короткую версию, которую легко передать другу:
    </blockquote>
    <form method="get" action="/create">
        <div class="form-group">
            <label for="link">Введите ссылку</label>
            <input type="text" class="form-control" name="link" id="link" placeholder="https://domain.com"
                   value="https://domain.com">
        </div>

        <button type="submit" class="btn btn-default">Создать короткую ссылку</button>
    </form>
    <hr>
    <?php
    $entries_by_ip = (new Url())->find_short_links_by_ip($_SERVER['REMOTE_ADDR']);
    $entries_by_sid = (new Url())->find_short_links_by_sid(session_id());
    ?>
    <b>История запросов по IP</b>
    <table class="table">
        <thead>
        <tr>
            <th>Ссылка</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (empty($entries_by_ip)) {
            echo "<tr><td>Нет данных</td></tr>";
        } else {
            foreach ($entries_by_ip as $entry) {
                $date = date('d-m-Y H:i:s', $entry['date_create']);
                echo "<tr><td><a href=\"https://localhost/go?{$entry['short_url']}\">{$entry['short_url']}</a></td><td>{$date}</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
    <br>
    <b>История запросов по сессии</b>
    <table class="table">
        <thead>
        <tr>
            <th>Ссылка</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (empty($entries_by_sid)) {
            echo "<tr><td>Нет данных</td></tr>";
        } else {
            foreach ($entries_by_sid as $entry) {
                $date = date('d-m-Y H:i:s', $entry['date_create']);
                echo "<tr><td><a href=\"https://localhost/go?{$entry['short_url']}\">{$entry['short_url']}</a></td><td>{$date}</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
