<?php

namespace BoostBoard\Middlewares;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use BoostBoard\Core\TemplateRenderer;

class SecureAuthentication extends AbstractMiddleware
{

    /**
     * The constructor initialize database connection.
     */
    public function __construct()
    {
        $this->db = new \PDO('sqlite:data.db');
    }

    /**
     * Authenticate user, if valid then set the session.
     *
     * @param Request $req - The request object.
     *
     * @return bool - Whether the user is valid.
     */
    private function authenticate(Request &$req): void
    {
        $username = $req->getParam('username');
        $password = $req->getParam('password');
        $sth = $this->db->prepare('SELECT id, privilege FROM users WHERE username = ? AND password = ?');
        $sth->execute([$username, hash('sha256', $password)]);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($result != false) {
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $sth = $this->db->prepare('INSERT INTO sessions (userID, token) VALUES (?, ?)');
            $sth->execute([$result['id'], $token]);

            $req->setSession('userId', $result['id']);
            $req->setSession('token', $token);
        }
    }

    /**
     * Verify user session
     *
     * @param Request &$req - The request object.
     *
     * @return bool - Whether the token is valid.
     */
    private function verifySession(Request &$req): bool
    {
        $sth = $this->db->prepare('SELECT userId FROM sessions WHERE token = ? ');
        $sth->execute([$req->getSession('token')]);
        if ($userId = $sth->fetchColumn()) {
            $sth = $this->db->prepare('SELECT privilege FROM users WHERE id = ?');
            $sth->execute([$userId]);
            $req->setPrivilege($sth->fetchColumn());
            return true;
        }
        return false;
    }

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
        if (!is_null($req->getSession('token'))) {
            if ($req->uri == '/logout' || !$this->verifySession($req)) {
                $req->unsetSession('token');
                $res->block();
                $res->setRedirect('/');
            }
            // Otherwise, permit the access.
        } elseif ($req->uri == '/login' && $req->getMethod() == 'POST') {
            $this->authenticate($req);
            $res->block();
            $res->setRedirect('/');
        } else {
            $template = new TemplateRenderer($req);
            $res->block();
            $res->setPayload($template('auth.twig', []));
        }
        return $res;
    }
}
