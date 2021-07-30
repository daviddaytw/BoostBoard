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
     * @param Request  &$req  - The request object.
     * @param Response $res - The response object.
     *
     * @return bool - Whether to pass to next middleware.
     */
    public function __invoke(Request &$req, Response $res): Response
    {
        if ($req->getMethod() == 'POST') {
            $req_token = $req->getParam('_token');
            $csrf_token = $req->getSession('csrf_token');
            if (!hash_equals($req_token, $csrf_token)) {
                $res->block();
                $res->setPayload('<h1>403 Forbidden</h1>CSRF verification failed.');
            }
        } else {
            $req->setSession('csrf_token', bin2hex(random_bytes(32)));
        }
        return $res;
    }
}
