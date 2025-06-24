<?php
function getBindTypes($params)
{
    $types = '';
    foreach ($params as $param) {
        if (is_int($param)) {
            $types .= 'i';
        } elseif (is_double($param)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
    }
    return $types;
}
