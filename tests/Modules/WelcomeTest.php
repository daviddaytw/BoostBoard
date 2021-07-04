<?php declare(strict_types=1);
namespace BoostBoard\Test\Modules;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;
use BoostBoard\Modules\Welcome\Controller;

final class WelcomeTest extends TestCase
{
    public function testIndex(): void
    {
        $controller = new Controller('src/Modules/Welcome');
        $request = new Request('/');
        $response = new Response();
        $controller->render($request, $response);
        $this->assertStringContainsString('Welcome', $response->getPayload());
    }
}
