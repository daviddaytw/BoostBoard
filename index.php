<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/


session_start();
$url = strtok($_SERVER["REQUEST_URI"], '?');
$method = $_SERVER['REQUEST_METHOD'];
$request = new \BoostBoard\Core\Request($url, $method, $_REQUEST, $_SESSION);
$response = new \BoostBoard\Core\Response();

$middlewareInvoker = new \BoostBoard\Core\MiddlewareInvoker();
$middlewareInvoker($request, $response);

if (!$response->isBlock()) {
    $router = new \BoostBoard\Core\Router($request->getPrivilege());
    $router($request, $response);
}

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/theme');
$twig = new \Twig\Environment($loader);

$statusCode = $response->getStatusCode();
http_response_code($statusCode);
switch ($statusCode) {
    case 200:
        $template = $twig->load('layout.twig');
        echo $template->render(
            [
            'modules' => $router->getModules(),
            'content' => $response->getPayload()
            ]
        );
        break;
    case 404:
        $template = $twig->load('404.twig');
        echo $template->render();
        break;
    case 302:
        header($response->getRedirectHeader());
        break;
    default:
        echo $response->getPayload();
        break;
}
