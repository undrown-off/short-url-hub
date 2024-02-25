<?php
if (!isset($parse_url)) {
    die();
}

if (!isset($parse_url["query"])) {
    error_500("query not found");
} else {
    if (empty($parse_url["query"])) {
        error_500("query is empty");
    }
}

if ($redirect = find_short_link($parse_url["query"])) {
    header("Location: {$redirect}");
} else {
    error_404("URL not found");
}
die();