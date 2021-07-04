<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testConstruct(): Response
    {
        $response = new Response();
        $this->assertNotNull($response);
        return $response;
    }

    /**
     * @depends testConstruct
     */
    public function testRedirect(Response $response): Response
    {
        $URL = '/test';
        $response->setRedirect($URL);
        $this->assertEquals('Location: ' . $URL, $response->getRedirectHeader());
        return $response;
    }

    /**
     * @depends testConstruct
     */
    public function testPayload(Response $response): Response
    {
        $testPayload = 'Some payload';
        $response->setPayload($testPayload);
        $this->assertEquals($testPayload, $response->getPayload());
        return $response;
    }
}
