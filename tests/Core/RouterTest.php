<?php declare(strict_types=1);
namespace BoostBoard\Test\Core;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;
use BoostBoard\Core\Router;

final class RouterTest extends TestCase
{
    public function testRouteTable(): Router
    {
        $router = new Router(-9999);
        $visibleModules = $router->getModules();
        $this->assertEmpty($visibleModules);


        $router = new Router(9999);
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

    public function testInvoke(): void
    {
        $request = new Request('/', 'GET');
        $response = new Response();
        $router = new Router(9999);
        $router($request, $response);
        $this->assertEquals(200, $response->getStatusCode());


        $router = new Router(-9999);
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
