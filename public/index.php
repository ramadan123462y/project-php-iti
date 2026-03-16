<?php

session_start();
require "../App/helpers.php";
require "../App/errors.php";


spl_autoload_register(function ($class) {

    // Convert namespace "\" into folder path "/"
    $class = str_replace("\\", "/", $class);

    // Load the corresponding PHP file
    require "../" . $class . ".php";
});


use App\Core\Request;

$uri = trim(Request::uri(), "/");

$parts = explode("/", $uri);

$controllerName = !empty($parts[0])
    ? ucfirst($parts[0]) . "Controller"
    : "HomeController";

$controllerClass = "App\\Controllers\\" . $controllerName;


$method = $parts[1] ?? "index";

$params = array_slice($parts, 2);


if (!class_exists($controllerClass)) {
    echo "Controller not found";
    exit;
}



$controller = new $controllerClass;



if (!method_exists($controller, $method)) {
    echo "Method not found";
    exit;
}



call_user_func_array([$controller, $method], $params);
