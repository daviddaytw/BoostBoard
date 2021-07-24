<?php

namespace BoostBoard\Middlewares;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class CSRFProtection extends AbstractMiddleware
{
    /**
     * Invoke the middleware for CSRF protection.
     *
     * This middleware will verify and generate token to store in seesion.
     *
     * @param Request  &$request  - The request object.
     * @param Response &$response - The response object.
     *
     * @return bool - Whether to pass to next middleware.
     */
    public function __invoke(Request &$request, Response &$response): void
    {
        if ($request->getMethod() == 'POST') {
            $request_token = $request->getParam('_token');
            $csrf_token = $request->getSession('csrf_token');
            if (!hash_equals($request_token, $csrf_token)) {
                $response->block();
                $response->setPayload('<h1>403 Forbidden</h1>CSRF verification failed.');
                return ;
            }
        }
        $request->setSession('csrf_token', bin2hex(random_bytes(32)));
    }
}
