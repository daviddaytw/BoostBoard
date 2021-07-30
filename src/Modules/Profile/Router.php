<?php

namespace BoostBoard\Modules\Profile;

use BoostBoard\Core\AbstractRouter;

class Router extends AbstractRouter
{
    public static $config = [
        'display' => 'Profile',
        'route' => '/profile',
        'permission' => 1,
        'database' => [
            'dsn' => 'sqlite:data.db'
        ]
    ];

    public function __construct()
    {
        parent::__construct(self::$config);

        $this->get('/', Controller::class, 'index');
        $this->post('/', Controller::class, 'update');
    }
}
