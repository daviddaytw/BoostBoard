<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use BoostBoard\Core\BaseController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

final class ControllerTest extends TestCase
{
    public function testConstruct(): BaseController
    {
        $modulePath = 'src/Modules/Welcome/';
        $config = json_decode(file_get_contents($modulePath . '/config.json'));
        $controller = new BaseController($modulePath, $config);
        $this->assertNotNull($controller);
        return $controller;
    }

    /**
     * @depends testConstruct
     */
    public function testRender(BaseController $controller): BaseController
    {
        $controller->addRoute(
            '/test', function () {
                return 'Test Message';
            }
        );
        $request = new Request('/test', 'GET');
        $request->setPrivilege(0);
        $response = new Response();
        $controller->render($request, $response);
        $this->assertEquals('Test Message', $response->getPayload());

        return $controller;
    }

    /**
     * @depends testConstruct
     */
    public function testView(BaseController $controller): BaseController
    {
        $result = $controller->view('pages/index.twig');
        $this->assertIsString($result);

        return $controller;
    }
}