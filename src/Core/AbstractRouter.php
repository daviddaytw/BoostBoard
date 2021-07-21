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
     * @param Request  $request  - The request object.
     * @param Response $response - The resposne object.
     */
    public function __invoke(Request $request, Response &$response): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] == $request->uri && $route['method'] == $request->method) {
                $controller = new $route['controller']($request, $response);
                $callback = $route['callback'];
                $payload = $controller->$callback($this->db);
                if (!is_null($payload)) {
                    $response->setPayload($payload);
                }
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
