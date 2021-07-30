<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use PHPUnit\Framework\TestCase;
use BoostBoard\Core\MiddlewareInvoker;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

final class MiddlwareTest extends TestCase
{
    public function testInvoke(): MiddlewareInvoker
    {
        $middleware = new MiddlewareInvoker();
        $req = new Request('/', 'GET', ['privilege' => 0]);
        $res = new Response();
        $res = $middleware($req, $res);
        $this->assertNotNull($res->getPayload());
        return $middleware;
    }
}
