<?php

declare(strict_types=1);

namespace BoostBoard\Test\Modules;

use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use PHPUnit\Framework\TestCase;
use BoostBoard\Modules\Welcome\Router;

final class WelcomeTest extends TestCase
{
    public function testIndex(): void
    {
        $router = new Router();
        $request = new Request('/');
        $response = new Response();
        $router($request, $response);
        $this->assertStringContainsString('Welcome', $response->getPayload());
    }
}
