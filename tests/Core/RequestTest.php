<?php

declare(strict_types=1);

namespace BoostBoard\Test\Core;

use BoostBoard\Core\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testConstruct(): Request
    {
        $req = new Request('/', 'GET');
        $this->assertNotNull($req);

        return $req;
    }

    /**
     * @depends testConstruct
     */
    public function testPrivilege(Request $req): Request
    {
        $privilege = 3;
        $req->setPrivilege($privilege);
        $this->assertEquals($privilege, $req->getPrivilege());
        return $req;
    }

    public function testParam(): Request
    {
        $value = 'Some val';
        $req = new Request('/', 'POST', ['p' => $value]);
        $this->assertEquals($value, $req->getParam('p'));
        $this->assertNull($req->getParam('q'));
        return $req;
    }

    /**
     * @depends testConstruct
     */
    public function testSession(Request $req): Request
    {
        $key = 'key';
        $value = 'some val';
        $req->setSession($key, $value);
        $this->assertEquals($value, $req->getSession($key));
        $req->unsetSession($key);
        $this->assertNull($req->getSession($key));
        return $req;
    }
}
