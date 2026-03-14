<?php

/*
|--------------------------------------------------------------------------
| 1. Load Global Helper Functions
|--------------------------------------------------------------------------
| This file usually contains global helper functions used across
| the application such as:
| view(), redirect(), dd(), etc.
|
| Example helper:
| function view($name) { require "../views/$name.php"; }
|
*/
session_start();
require "../App/helpers.php";
function test(){

echo "test";
}


/*
|--------------------------------------------------------------------------
| 2. Autoloader (Automatic Class Loader)
|--------------------------------------------------------------------------
| Instead of manually including every class file,
| this function automatically loads a class when it is used.
|
| Example:
| If we create a class:
| App\Controllers\UserController
|
| The autoloader will convert the namespace into a file path:
|
| App\Controllers\UserController
|        ↓
| App/Controllers/UserController.php
|
*/

spl_autoload_register(function ($class) {

    // Convert namespace "\" into folder path "/"
    $class = str_replace("\\", "/", $class);

    // Load the corresponding PHP file
    require "../" . $class . ".php";
});


/*
|--------------------------------------------------------------------------
| 3. Import Request Class
|--------------------------------------------------------------------------
| This class usually handles request-related data such as:
|
| - URL
| - HTTP Method
| - Query parameters
|
*/

use App\Core\Request;


/*
|--------------------------------------------------------------------------
| 4. Example URL Structure
|--------------------------------------------------------------------------
|
| Example URL:
| http://localhost/users/show/20
|
| Expected mapping:
|
| Controller : UserController
| Method     : show()
| Parameter  : 20
|
*/


/*
|--------------------------------------------------------------------------
| 5. Get Current URL
|--------------------------------------------------------------------------
|
| Request::uri() might return something like:
|
| /users/show/20
|
| trim(..., "/") removes leading and trailing slashes
|
| Result:
| users/show/20
|
*/

$uri = trim(Request::uri(), "/");


/*
|--------------------------------------------------------------------------
| 6. Split URL into Parts
|--------------------------------------------------------------------------
|
| explode("/", $uri) splits the URL by "/"
|
| Example:
|
| users/show/20
|
| becomes:
|
| [
|   "users",
|   "show",
|   "20"
| ]
|
*/

$parts = explode("/", $uri);


/*
|--------------------------------------------------------------------------
| 7. Determine Controller Name
|--------------------------------------------------------------------------
|
| First segment represents the controller.
|
| Example:
|
| URL: /users/show/20
|
| $parts[0] = "users"
|
| We convert it to:
| UserController
|
| ucfirst() capitalizes the first letter.
|
| If no controller is provided (homepage):
|
| URL: /
|
| We default to:
| HomeController
|
*/

$controllerName = !empty($parts[0])
    ? ucfirst($parts[0]) . "Controller"
    : "HomeController";


/*
|--------------------------------------------------------------------------
| 8. Build Full Controller Class Path
|--------------------------------------------------------------------------
|
| Controllers are stored inside:
|
| App\Controllers\
|
| Example result:
|
| App\Controllers\UserController
|
*/

$controllerClass = "App\\Controllers\\" . $controllerName;


/*
|--------------------------------------------------------------------------
| 9. Determine Method Name
|--------------------------------------------------------------------------
|
| Second URL segment represents the method.
|
| Example:
|
| URL: /users/show/20
|
| $parts[1] = "show"
|
| If no method is provided:
|
| URL: /users
|
| We default to:
| index()
|
*/

$method = $parts[1] ?? "index";


/*
|--------------------------------------------------------------------------
| 10. Extract Method Parameters
|--------------------------------------------------------------------------
|
| Everything after the method is considered a parameter.
|
| Example:
|
| URL: /users/show/20
|
| $parts = ["users", "show", "20"]
|
| array_slice($parts, 2)
|
| Result:
| ["20"]
|
*/

$params = array_slice($parts, 2);


/*
|--------------------------------------------------------------------------
| 11. Check If Controller Exists
|--------------------------------------------------------------------------
|
| Prevent fatal errors if the controller doesn't exist.
|
| Example:
|
| URL: /products
|
| If ProductsController doesn't exist,
| we stop execution.
|
*/

if (!class_exists($controllerClass)) {
    echo "Controller not found";
    exit;
}


/*
|--------------------------------------------------------------------------
| 12. Create Controller Instance
|--------------------------------------------------------------------------
|
| Example:
|
| $controller = new UserController();
|
*/

$controller = new $controllerClass;


/*
|--------------------------------------------------------------------------
| 13. Check If Method Exists
|--------------------------------------------------------------------------
|
| Example:
|
| URL: /users/show
|
| If show() doesn't exist inside UserController,
| we stop execution.
|
*/

if (!method_exists($controller, $method)) {
    echo "Method not found";
    exit;
}


/*
|--------------------------------------------------------------------------
| 14. Call Controller Method Dynamically
|--------------------------------------------------------------------------
|
| call_user_func_array executes a method dynamically
| and passes parameters as an array.
|
| Example:
|
| URL: /users/show/20
|
| This line becomes equivalent to:
|
| $controller->show(20);
|
*/

call_user_func_array([$controller, $method], $params);
