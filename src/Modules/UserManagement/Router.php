<?php

namespace BoostBoard\Modules\UserManagement;

use BoostBoard\Core\AbstractRouter;

class Router extends AbstractRouter
{
    public static $config = [
        'display' => 'Users',
        'route' => '/users',
        'permission' => 250,
        'database' => [
            'dsn' => 'sqlite:data.db'
        ],
        'subLink' => [
            'User List' => '/users',
            'Create User' => '/users/create'
        ]
    ];

    public function __construct()
    {
        parent::__construct(self::$config);

        $this->get('/', Controller::class, 'index');
        $this->get('/create', Controller::class, 'create');
        $this->post('/create', Controller::class, 'store');
        $this->get('/delete', Controller::class, 'delete');
        $this->get('/clear-session', Controller::class, 'clearSession');
        $this->post('/update-password', Controller::class, 'updatePassword');
    }
}
