<?php

define('BOOSTBOARD_START', microtime(true));

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

require __DIR__.'/vendor/autoload.php';

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


$url = strtok($_SERVER["REQUEST_URI"], '?');
$method = $_SERVER['REQUEST_METHOD'];
$request = (object) $_REQUEST;
session_start();

$middleware = new \BoostBoard\Core\Middleware;
if ( $middleware($url, $method, $request) )
{

  $router = new \BoostBoard\Core\Router;
  $content = $router($url, $method, $request);
  
  $loader = new \Twig\Loader\FilesystemLoader(__DIR__. '/theme');
  $twig = new \Twig\Environment($loader);
  
  if( $content )
  {
    $template = $twig->load('layout.twig');
    echo $template->render([
      'modules' => $router->getModules(),
      'content' => $content
    ]);
  }
  else
  {
    $template = $twig->load('404.twig');
    echo $template->render();
    http_response_code(404);
  }  
}
