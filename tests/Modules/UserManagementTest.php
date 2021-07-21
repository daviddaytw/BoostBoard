<?php

declare(strict_types=1);

namespace BoostBoard\Test\Modules;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;
use BoostBoard\Modules\UserManagement\Router;

final class UserManagementTest extends TestCase
{
    public function testIndex(): Router
    {
        $router = new Router();
        $request = new Request('/');
        $response = new Response();
        $router($request, $response);
        $this->assertNotNull($response->getPayload());

        return $router;
    }

    /**
     * @depends testIndex
     */
    public function testCreate(Router $router): Router
    {
        $request = new Request(
            '/create',
            'POST',
            [
            'username' => 'test',
            'password' => 'test',
            'privilege' => '0'
            ]
        );
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(302, $response->getStatusCode());
        return $router;
    }

    /**
     * @depends testCreate
     */
    public function testDelete(Router $router): void
    {
        $request = new Request(
            '/delete',
            'GET',
            [
            'id' => '1',
            ]
        );
        $response = new Response();
        $router($request, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
