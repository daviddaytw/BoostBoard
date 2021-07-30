<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testConstruct(): Response
    {
        $res = new Response();
        $this->assertNotNull($res);
        return $res;
    }

    /**
     * @depends testConstruct
     */
    public function testRedirect(Response $res): Response
    {
        $URL = '/test';
        $res->setRedirect($URL);
        $this->assertEquals('Location: ' . $URL, $res->getRedirectHeader());
        return $res;
    }

    /**
     * @depends testConstruct
     */
    public function testPayload(Response $res): Response
    {
        $testPayload = 'Some payload';
        $res->setPayload($testPayload);
        $this->assertEquals($testPayload, $res->getPayload());
        return $res;
    }
}
