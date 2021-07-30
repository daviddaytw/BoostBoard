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

use BoostBoard\Core\TemplateRenderer;

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
$req = new \BoostBoard\Core\Request($url, $method, $_REQUEST, $_SESSION);
$res = new \BoostBoard\Core\Response();

$middlewareInvoker = new \BoostBoard\Core\MiddlewareInvoker();
$res = $middlewareInvoker($req, $res);

if (!$res->isBlock()) {
    $router = new \BoostBoard\Core\RouteHandler($req->getPrivilege());
    $res = $router($req, $res);
}

$statusCode = $res->getStatusCode();
http_response_code($statusCode);
switch ($statusCode) {
    case 404:
        $renderer = new TemplateRenderer($req);
        echo $renderer('404.twig');
        break;
    case 302:
        header($res->getRedirectHeader());
        break;
    default:
        echo $res->getPayload();
        break;
}
