<?php
namespace BoostBoard\Core;

class Middleware
{
    /**
     * List of middlewares, the request will be pass by the order in this array.
     */
    protected $middlewares = [
        \BoostBoard\Middlewares\SecureAuthentication::class,
    ];

    /**
     * Invoking middleware to let request pass all middlewares.
     *
     * @param Request  &$request  - The request object.
     * @param Response &$response - The response object.
     */
    public function __invoke(Request &$request, Response &$response) : void
    {
        foreach ($this->middlewares as $class) {
            $middleware = new $class();
            $middleware($request, $response);
            if ($response->isBlock()) {
                break;
            }
        }
    }
}
