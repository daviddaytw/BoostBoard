<?php

namespace BoostBoard\Core;

use PDO;

class AbstractRouter
{
    public PDO $db;
    private $routes = [];

    /**
     * Consturctor for controller.
     *
     * The constructor will prepare database connection if exist.
     *
     * @param $config - The configuration object.
     */
    public function __construct($config)
    {
        if (array_key_exists('database', $config)) {
            $dbConfig = $config['database'];
            $this->db = new PDO($dbConfig['dsn'], $dbConfig['user'] ?? null, $dbConfig['password'] ?? null);
        }
    }

    /**
     * Invoke the router.
     *
     * @param Request  $req  - The request object.
     * @param Response $res - The resposne object.
     */
    public function __invoke(Request $req, Response $res): Response
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $req->uri && $route['method'] == $req->getMethod()) {
                $controller = new $route['controller']($req, $res);
                $callback = $route['callback'];
                $res = $controller->$callback($req, $res, $this->db);
                return $res;
            }
        }
    }

    /**
     * Register a request callback for the controller.
     *
     * @param string $uri      - The uri for the request.
     * @param string $method   - The method for the request.
     * @param string $classname - The classname of the controller.
     * @param string $callback - The callback for the request.
     */
    private function addRoute(string $uri, string $method, string $classname, string $callback): void
    {
        array_push(
            $this->routes,
            [
                'uri' => $uri,
                'method' => $method,
                'controller' => $classname,
                'callback' => $callback
            ]
        );
    }

    /**
     * Register a GET request.
     *
     * @param string $uri      - The uri for the request.
     * @param string $classname - The classname of the controller.
     * @param string $callback - The callback for the request.
     */
    public function get(string $uri, string $classname, string $callback): void
    {
        $this->addRoute($uri, 'GET', $classname, $callback);
    }

    /**
     * Register a POST request.
     *
     * @param string $uri      - The uri for the request.
     * @param string $classname - The classname of the controller.
     * @param string $callback - The callback for the request.
     */
    public function post(string $uri, string $classname, string $callback): void
    {
        $this->addRoute($uri, 'POST', $classname, $callback);
    }
}
