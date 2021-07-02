<?php
namespace BoostBoard\Core;
use \PDO;

class BaseController
{
    public $db;
    public $config;
    private $twig;
    private $routes = [];

    /**
     * Consturctor for controller.
     * 
     * The constructor to the following actinos:
     * - Prepare twig environment for further render usage.
     * - Prepare database connection if exist.
     */
    public function __construct($root, $config)
    {
        $this->config = $config;

        $loader = new \Twig\Loader\FilesystemLoader($root);
        $this->twig = new \Twig\Environment($loader);

        if (property_exists($this->config, 'database')) {
            $dbConfig = $this->config->database;
            $this->db = new PDO($dbConfig->dsn, $dbConfig->user ?? null, $dbConfig->password ?? null);
        }
    }

    /**
     * Render the page.
     * 
     * @param  String $uri    - The requested uri.
     * @param  String $method - The request HTTP method.
     * @return String - The HTML Content for the page.
     */
    public function render(String $uri, String $method, $request)
    {
        foreach($this->routes as $route)
        {
            if($route['uri'] == $uri && $route['method'] == $method) {
                return $route['callback']($request);
            }
        }
    }

    /**
     * Register a request callback for the controller.
     * 
     * @param String $uri      - The uri for the request.
     * @param $callback - The callback for the request.
     * @param String $method   - The method for the request.
     */
    public function addRoute(String $uri, $callback, String $method='GET')
    {
        array_push(
            $this->routes, [
            'uri' => $uri,
            'method' => $method,
            'callback' => $callback
            ]
        );
    }

    /**
     * Render the Twig template.
     * 
     * @param  String $path   - The filepath of the template, root path is directory `pages`.
     * @param  Array  $params - The parameters to render the template.
     * @return String - The rendered result.
     */
    public function view(String $path, Array $params = [])
    {
        $template = $this->twig->load($path);
        return $template->render($params);
    }
}