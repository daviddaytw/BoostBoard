<?php
namespace BoostBoard\Core;

class Router
{
    private $modules = [];
  
    /**
     * Route table will be generate when constructing.
     *
     * @param int $privilege - The privilege level of user.
     */
    public function __construct($privilege)
    {
        $this->createRouteTable($privilege);
    }
  
    /**
     * Retrieve the list of generated modules.
     *
     * @return Array - The list of module.
     */
    public function getModules()
    {
        $results = $this->modules;
        usort(
            $results,
            function ($a, $b) {
                $orderA = $a->config['order'];
                $orderB = $b->config['order'];
                if ($orderA < $orderB) {
                    return -1;
                } elseif ($orderA == $orderB) {
                    return 0;
                } else {
                    return 1;
                }
            }
        );
        return $results;
    }

    /**
     * Generate route table for the user.
     *
     * @param int $privilege - The privilege level of user.
     */
    private function createRouteTable(int $privilege)
    {
        $modules = scandir(__DIR__.'/../Modules');
        foreach ($modules as $module) {
            $path = __DIR__.'/../Modules/' . $module;
            if (is_dir($path) && is_file($path.'/config.json')) {
                $class  = '\BoostBoard\Modules\\'.$module.'\Controller';
                $rawConfig = file_get_contents($path . '/config.json');
                $config = json_decode($rawConfig, true);

                if ($privilege >= $config['permission']) {
                    $this->modules[$config['route']] = (object) [
                        'controller' => $class,
                        'config' => $config
                    ];
                }
            }
        }
    }

    /**
     * Invoking router will call the corresponding controller to render the page.
     *
     * @param Request  $request   - The request object.
     * @param Response &$response - The response object.
     */
    public function __invoke(Request $request, Response &$response) : void
    {
        $route = '/' . strtok($request->uri, '/');
        $remain = '/' . substr($request->uri, strlen($route) + 1);
        $request->uri = $remain;

        if (array_key_exists($route, $this->modules)) {
            $module = $this->modules[$route];
            $class = $module->controller;
            $controller = new $class();
            $controller->render($request, $response);
        } else {
            $response->setStatusCode(404);
        }
    }
}
