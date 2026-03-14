<?php

function url($path = '')
{
    $base = dirname($_SERVER['SCRIPT_NAME']);

    return rtrim($base, '/') . '/' . ltrim($path, '/');
}
function redirect($path = '')
{
    header("Location: ".url($path));
    exit;
}

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}