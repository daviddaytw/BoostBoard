<?php

namespace BoostBoard\Middlewares;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

abstract class AbstractMiddleware
{
    /**
     * Invoke the middleware will check if request is authenticated.
     *
     * @param Request  &$req  - The request object.
     * @param Response $res - The response object.
     *
     * @return bool - Whether to pass to next middleware.
     */
    public function __invoke(Request &$req, Response $res): Response
    {
        // code here
        return $res;
    }
}
