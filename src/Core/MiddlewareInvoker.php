<?php

namespace BoostBoard\Core;

class MiddlewareInvoker
{
    /**
     * List of middlewares, the request will be pass by the order in this array.
     */
    protected $middlewares = [
        \BoostBoard\Middlewares\CSRFProtection::class,
        \BoostBoard\Middlewares\SecureAuthentication::class,
    ];

    /**
     * Invoking middleware to let request pass all middlewares.
     *
     * @param Request  &$req  - The request object.
     * @param Response $res - The response object.
     */
    public function __invoke(Request &$req, Response $res): Response
    {
        foreach ($this->middlewares as $class) {
            $middleware = new $class();
            $res = $middleware($req, $res);
            if ($res->isBlock()) {
                break;
            }
        }
        return $res;
    }
}
