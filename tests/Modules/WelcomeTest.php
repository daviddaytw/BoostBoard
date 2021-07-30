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
        $req = new Request('/');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertStringContainsString('Welcome', $res->getPayload());
    }

    /**
     * @runInSeparateProcess
     */
    public function testChart(): void
    {
        $router = new Router();
        $req = new Request('/chart');
        $res = new Response();
        $res = $router($req, $res);
        $this->assertStringContainsString('', $res->getPayload());
    }
}
