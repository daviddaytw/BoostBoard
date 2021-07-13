<?php

namespace BoostBoard\Middlewares;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

abstract class AbstractMiddleware
{
    /**
     * Invoke the middleware will check if request is authenticated.
     *
     * @param Request  &$request  - The request object.
     * @param Response &$response - The response object.
     *
     * @return bool - Whether to pass to next middleware.
     */
    public function __invoke(Request &$request, Response &$response): void
    {
        // code here
    }
}
