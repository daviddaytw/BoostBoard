<?php

namespace BoostBoard\Modules\Welcome;

use BoostBoard\Core\AbstractRouter;

class Router extends AbstractRouter
{
    public static $config = [
        'display' => 'Welcome',
        'route' => '/',
        'order' => -1,
        'permission' => 0,
        'database' => [
            'dsn' => 'sqlite:data.db'
        ]
    ];

    public function __construct()
    {
        parent::__construct(self::$config);

        $this->get('/', Controller::class, 'index');
        $this->get('/chart', Controller::class, 'plotChart');
    }
}
