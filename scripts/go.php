<?php
if (!isset($parse_url)) {
    die();
}

$url = new Url();

if (!isset($parse_url["query"])) {
    Errors::code_500("query not found");
} else {
    if (empty($parse_url["query"])) {
        Errors::code_500("query is empty");
    }
}

if ($redirect = $url->find_short_link($parse_url["query"])) {
    header("Location: {$redirect}");
} else {
    Errors::code_404("URL not found");
}
die();