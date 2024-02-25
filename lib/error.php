<?php

/********************************/
/* библиотека обработчик ошибок */
/********************************/

/**
 * @param $message
 * @return void
 */
function error_404($message = "Page not found")
{
    http_response_code(404);
    exit($message);
}

/**
 * @param $message
 * @return void
 */
function error_500($message = "Internal server error")
{
    http_response_code(500);
    exit($message);
}
