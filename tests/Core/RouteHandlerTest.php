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
        $request = new Request('/', 'GET');
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(200, $response->getStatusCode());


        $request = new Request('/users', 'GET');
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNotFound(): void
    {
        $router = new RouteHandler(-1);
        $request = new Request('/', 'GET');
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
