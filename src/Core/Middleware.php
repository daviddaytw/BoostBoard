<?php
namespace BoostBoard\Core;

class Middleware {
    protected $middlewares = [
        \BoostBoard\Middlewares\SecureAuthentication::class,
    ];

    public function __invoke($uri, $method, &$request)
    {
        foreach($this->middlewares as $class)
        {
            $middleware = new $class();
            if( !$middleware($uri, $method, $request) )
            {
                return false;
            }
        }
        return true;
    }
}