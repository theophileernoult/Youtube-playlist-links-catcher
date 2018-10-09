<?php

/**
 * @param string $param
 * @return mixed
 */
function getParam($param = '')
{
    $url = filter_input(INPUT_GET, 'url');
    $parts = parse_url($url);
    parse_str($parts['query'], $query);
    if ($param !== '') {
        return $query[$param];
    } else {
        return false;
    }
}