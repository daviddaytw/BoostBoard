<?php

namespace BoostBoard\Core;

class Request
{
    /**
     * Construct a request.
     *
     * @param string $uri     - The URI of the request.
     * @param string $method  - The HTTP method of the request.
     * @param array  $params  - The parameters passed by the request.
     * @param array  $session - The session data of the request.
     */
    public function __construct(string $uri, string $method = 'GET', array $params = [], array $session = [])
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->params = $params;
        $this->privilege = -1;
        $this->session = $session;
    }

    /**
     * Get the privilege level of the request.
     *
     * @return int - The privilege level.
     */
    public function getPrivilege(): int
    {
        return $this->privilege;
    }

    /**
     * Set the privilege level of the request.
     *
     * @param int $privilege - The privilege level.
     */
    public function setPrivilege(int $privilege): void
    {
        $this->privilege = $privilege;
    }

    /**
     * Get a parameter in the request.
     *
     * @param string $key - The key of the parameter.
     */
    public function getParam(string $key)
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        } else {
            return null;
        }
    }

    /**
     * Get a parameter in the session data of the request.
     *
     * @param string $key - The key of the parameter.
     */
    public function getSession(string $key)
    {
        if (isset($this->session[$key])) {
            return $this->session[$key];
        } else {
            return null;
        }
    }

    /**
     * Set session data to the request
     *
     * @param string $key   - The key of the data.
     * @param string $value - The value of the data.
     */
    public function setSession(string $key, $value): void
    {
        $this->session[$key] = $value;
        $_SESSION[$key] = $value;
    }

    /**
     * Delete session data of the request.
     *
     * @param string $key - The key to delete data.
     */
    public function unsetSession(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key], $this->session[$key]);
        }
    }
}
