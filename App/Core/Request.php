<?php

namespace App\Core;

class Request
{
    public static function uri()
    {
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        $base = dirname($_SERVER["SCRIPT_NAME"]);

        if ($base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        return "/" . trim($uri, "/");
    }

    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}
