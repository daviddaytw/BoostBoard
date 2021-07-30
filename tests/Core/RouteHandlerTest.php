<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use BoostBoard\Core\RouteHandler;
use PHPUnit\Framework\TestCase;

final class RouteHandlerTest extends TestCase
{
    public function testInvoke(): void
    {
        $router = new RouteHandler(255);
        $req = new Request('/', 'GET');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertEquals(200, $res->getStatusCode());


        $req = new Request('/users', 'GET');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertEquals(200, $res->getStatusCode());
    }

    public function testNotFound(): void
    {
        $router = new RouteHandler(-1);
        $req = new Request('/', 'GET');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertEquals(404, $res->getStatusCode());
    }
}
