<?php declare(strict_types=1);
namespace BoostBoard\Test\Core;

use PHPUnit\Framework\TestCase;
use BoostBoard\Core\Middleware;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

final class MiddlwareTest extends TestCase
{
    public function testInvoke(): Middleware
    {
        $middleware = new Middleware();
        $request = new Request('/', 'GET', ['privilege' => 0]);
        $response = new Response();
        $middleware($request, $response);
        $this->assertNotNull($response->getPayload());
        return $middleware;
    }
}
