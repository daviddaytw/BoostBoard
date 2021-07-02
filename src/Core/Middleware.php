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
     * @param String $uri     - The requested URI.
     * @param String $method  - The HTTP method of the request.
     * @param String $request - The array containing the request parameters.
     * 
     * @return Boolean - Whether allow request to pass into router.
     */
    public function __invoke(String $uri,String $method, &$request)
    {
        foreach($this->middlewares as $class)
        {
            $middleware = new $class();
            if(!$middleware($uri, $method, $request)) {
                return false;
            }
        }
        return true;
    }
}
