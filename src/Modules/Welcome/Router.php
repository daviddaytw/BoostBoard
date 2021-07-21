<?php

namespace BoostBoard\Modules\Welcome;

use BoostBoard\Core\AbstractRouter;

class Router extends AbstractRouter
{
    public function __construct()
    {
        parent::__construct(__DIR__);

        $this->get('/', Controller::class, 'index');
    }
}
