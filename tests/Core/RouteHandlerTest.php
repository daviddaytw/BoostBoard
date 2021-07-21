<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use BoostBoard\Core\RouteHandler;
use PHPUnit\Framework\TestCase;

final class RouteHandlerTest extends TestCase
{
    public function testRouteTable(): RouteHandler
    {
        $router = new RouteHandler(255);
        $visibleModules = $router->getModules();
        $total_modules = 0;
        foreach (scandir('src/Modules') as $file) {
            if (is_file("src/Modules/$file/config.json")) {
                $total_modules++;
            }
        }
        $this->assertCount($total_modules, $visibleModules);

        return $router;
    }

    /**
     * @depends testRouteTable
     */
    public function testInvoke(RouteHandler $router): void
    {
        $request = new Request('/', 'GET');
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
