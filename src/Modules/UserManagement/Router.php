<?php

namespace BoostBoard\Modules\UserManagement;

use BoostBoard\Core\AbstractRouter;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;

class Router extends AbstractRouter
{
    public function __construct()
    {
        parent::__construct(__DIR__);

        $this->get('/', Controller::class, 'index');
        $this->get('/create', Controller::class, 'create');
        $this->post('/create', Controller::class, 'store');
        $this->get('/delete', Controller::class, 'delete');
        $this->get('/clear-session', Controller::class, 'clearSession');
        $this->post('/update-password', Controller::class, 'updatePassword');
    }
}
