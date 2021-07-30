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
        $req = new Request('/');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertNotNull($res->getPayload());

        return $router;
    }

    /**
     * @depends testIndex
     */
    public function testCreate(Router $router): Router
    {
        $req = new Request(
            '/create',
            'POST',
            [
            'username' => 'test',
            'password' => 'test',
            'privilege' => '0'
            ]
        );
        $res = new Response();
        $res = $router($req, $res);
        $this->assertEquals(302, $res->getStatusCode());
        return $router;
    }

    /**
     * @depends testCreate
     */
    public function testDelete(Router $router): void
    {
        $req = new Request(
            '/delete',
            'GET',
            [
            'id' => '1',
            ]
        );
        $res = new Response();
        $res = $router($req, $res);
        $this->assertEquals(302, $res->getStatusCode());
    }
}
