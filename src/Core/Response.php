<?php

namespace BoostBoard\Core;

class Response
{
    private $redirection = null;
    private $payload = null;
    private $block = false;
    private $status = 200;

    /**
     * Get the formatted header to redirect.
     *
     * @return string - The Header of redirect
     */
    public function getRedirectHeader(): string
    {
        return 'Location: ' . $this->redirection;
    }

    /**
     * Redirect the request
     *
     * @param $url - The URL to redirect.
     */
    public function setRedirect(string $url): void
    {
        $this->redirection = $url;
        $this->setStatusCode(302);
    }

    /**
     * Get the HTTP status code of response.
     *
     * @return int - The HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * Set the HTTP status code of response.
     *
     * @param int $code - The status code.
     */
    public function setStatusCode(int $code): void
    {
        $this->status = $code;
    }

    /**
     * Block the response, when response is blocked it won't pass to next segment.
     */
    public function block(): void
    {
        $this->setStatusCode(403);
        $this->block = true;
    }

    /**
     * Check if the response is blocked.
     *
     * @return bool - True of response is blocked, otherwise false.
     */
    public function isBlock(): bool
    {
        return $this->block;
    }

    /**
     * Set the payload to the response.
     *
     * @param string $payload - The payload for the response.
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * Get the payload of the response.
     *
     * @return string - The payload of the response.
     */
    public function getPayload(): string
    {
        return $this->payload;
    }
}
