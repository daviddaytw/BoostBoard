<?php

namespace BoostBoard\Middlewares;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class SecureAuthentication
{

    /**
     * The constructor initialize database connection.
     */
    public function __construct()
    {
        $this->db = new \PDO('sqlite:data/board.db');
    }

    /**
     * Authenticate user, if valid then set the session.
     *
     * @param Request $request - The request object.
     *
     * @return bool - Whether the user is valid.
     */
    private function authenticate(Request &$request): void
    {
        $username = $request->params['username'];
        $password = $request->params['password'];
        $sth = $this->db->prepare('SELECT id, privilege FROM users WHERE username = ? AND password = ?');
        $sth->execute([$username, hash('sha256', $password)]);
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($result != false) {
            $token = openssl_random_pseudo_bytes(16);
            $token = bin2hex($token);
            $sth = $this->db->prepare('INSERT INTO sessions (userID, token) VALUES (?, ?)');
            $sth->execute([$result['id'], $token]);

            $request->setSession('token', $token);
        }
    }

    /**
     * Verify user session
     *
     * @param Request &$request - The request object.
     *
     * @return bool - Whether the token is valid.
     */
    private function verifySession(Request &$request): bool
    {
        $sth = $this->db->prepare('SELECT userId FROM sessions WHERE token = ? ');
        $sth->execute([$request->getSession('token')]);
        if ($userId = $sth->fetchColumn()) {
            $sth = $this->db->prepare('SELECT privilege FROM users WHERE id = ?');
            $sth->execute([$userId]);
            $request->setPrivilege($sth->fetchColumn());
            return true;
        }
        return false;
    }

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
        if (!is_null($request->getSession('token'))) {
            if ($request->uri == '/logout' || !$this->verifySession($request)) {
                $request->unsetSession('token');
                $response->block();
                $response->setRedirect('/');
            }
            // Otherwise, permit the access.
        } elseif ($request->uri == '/login' && $request->method == 'POST') {
            $this->authenticate($request);
            $response->block();
            $response->setRedirect('/');
        } else {
            $loader = new \Twig\Loader\FilesystemLoader('theme');
            $twig = new \Twig\Environment($loader);

            $template = $twig->load('auth.twig');
            $response->block();
            $response->setPayload($template->render());
        }
    }
}
