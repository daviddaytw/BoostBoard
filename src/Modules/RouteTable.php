<?php

namespace BoostBoard\Modules;

class RouteTable
{
    protected $routers = [
        Welcome\Router::class,
        UserManagement\Router::class,
        Profile\Router::class,
    ];

    public function __invoke(int $privilege)
    {
        $modules = [];
        foreach ($this->routers as $router) {
            if ($privilege >= $router::$config['permission']) {
                array_push($modules, [
                    'prefix' => $router::$config['route'],
                    'router' => $router,
                    'config' => $router::$config
                ]);
            }
        }
        return $modules;
    }
}
