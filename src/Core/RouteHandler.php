<?php

namespace BoostBoard\Core;

use BoostBoard\Modules\RouteTable;

class RouteHandler
{
    private $modules = [];

    /**
     * Route table will be generate when constructing.
     *
     * @param int $privilege - The privilege level of user.
     */
    public function __construct(int $privilege)
    {
        $routeTable = new RouteTable();
        $this->modules = $routeTable($privilege);
    }


    /**
     * Invoking router will call the corresponding controller to render the page.
     *
     * @param Request  $request   - The request object.
     * @param Response &$response - The response object.
     */
    public function __invoke(Request $request, Response &$response): void
    {

        $routerClass = null;
        $prefixLength = 0;
        foreach ($this->modules as $module) {
            $route = $module['prefix'];
            if ($prefixLength < strlen($route)) {
                if (substr($request->uri, 0, strlen($route)) == $route) {
                    $routerClass = $module['router'];
                    $remain = substr($request->uri, strlen($route));
                    if ($remain == '' || $remain[0] != '/') {
                        $remain = '/' . $remain;
                    }
                    $prefixLength = strlen($route);
                }
            }
        }

        if ($routerClass != null) {
            $router = new $routerClass();
            $request->uri = $remain;
            $router($request, $response);
        } else {
            $response->setStatusCode(404);
        }
    }
}
