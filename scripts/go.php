<?php

if (!isset($parse_url)) {
    die();
}

if (!isset($parse_url["query"])) {
    Errors::code_500("query not found");
} else {
    if (empty($parse_url["query"])) {
        Errors::code_500("query is empty");
    }
}
$url = new Url();

if ($redirect = $url->found_by_short_link($parse_url["query"])) {
    header("Location: {$redirect['full_url']}");
} else {
    Errors::code_404("URL not found");
    
}
die();