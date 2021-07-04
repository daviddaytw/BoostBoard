<?php declare(strict_types=1);

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;
use BoostBoard\Modules\UserManagement\Controller;

final class UserManagementTest extends TestCase
{
    public function testIndex(): Controller
    {
        $controller = new Controller('src/Modules/UserManagement');
        $request = new Request('/');
        $response = new Response();
        $controller->render($request, $response);
        $this->assertNotNull($response->getPayload());

        return $controller;
    }

    /**
     * @depends testIndex
     */
    public function testCreate(Controller $controller): Controller
    {
        $request = new Request(
            '/create', 'POST', [
            'username' => 'test',
            'password' => 'test',
            'privilege' => '0'
            ]
        );
        $response = new Response();
        $controller->render($request, $response);
        $this->assertEquals(302, $response->getStatusCode());
        return $controller;
    }

    /**
     * @depends testCreate
     */
    public function testDelete(Controller $controller): void
    {
        $request = new Request(
            '/delete', 'GET', [
            'id' => '1',
            ]
        );
        $response = new Response();
        $controller->render($request, $response);
        $this->assertEquals(302, $response->getStatusCode());
    }
}
