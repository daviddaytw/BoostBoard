<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testConstruct(): Request
    {
        $request = new Request('/', 'GET');
        $this->assertNotNull($request);

        return $request;
    }

    /**
     * @depends testConstruct
     */
    public function testPrivilege(Request $request): Request
    {
        $privilege = 3;
        $request->setPrivilege($privilege);
        $this->assertEquals($privilege, $request->getPrivilege());
        return $request;
    }

    public function testParam(): Request
    {
        $value = 'Some val';
        $request = new Request('/', 'POST', ['p' => $value]);
        $this->assertEquals($value, $request->getParam('p'));
        $this->assertNull($request->getParam('q'));
        return $request;
    }

    /**
     * @depends testConstruct
     */
    public function testSession(Request $request): Request
    {
        $key = 'key';
        $value = 'some val';
        $request->setSession($key, $value);
        $this->assertEquals($value, $request->getSession($key));
        $request->unsetSession($key);
        $this->assertNull($request->getSession($key));
        return $request;
    }
}
