<?php
namespace BoostBoard\Core;

class Router
{
  private $modules = [];
  
  /**
   * Route table will be generate when constructing.
   */
  public function __construct()
  {
    $this->createRouteTable();
  }
  
  /**
   * Retrieve the list of generated modules.
   * 
   * @return Array - The list of module.
   */
  public function getModules()
  {
    $results = $this->modules;
    usort($results, function($a, $b) {
      $orderA = $a->config->order;
      $orderB = $b->config->order;
      if( $orderA < $orderB ) return -1;
      if( $orderA == $orderB ) return 0;
      if( $orderA > $orderB ) return 1;
    });
    return $results;
  }

  /**
   * Generate route table for the user.
   */
  private function createRouteTable()
  {
    $modules = scandir(__DIR__.'/../Modules');
    foreach ( $modules as $module )
    {
      $path = __DIR__.'/../Modules/' . $module;
      if ( is_dir($path) && is_file($path.'/config.json') )
      {
        $class  = '\BoostBoard\Modules\\'.$module.'\Controller';
        $rawConfig = file_get_contents($path . '/config.json');
        $config = json_decode($rawConfig);

        if($_SESSION['privilege'] >= $config->permission)
        {
          $this->modules[$config->route] = (object) [
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
   * @param String $uri - The requested URL
   * @param String $method - The HTTP method of request
   * @param $request - Request parameters
   * @return Boolean - Whether there exist the route.
   */
  public function __invoke(String $uri, String $method, $request)
  {
    $route = '/' . strtok($uri, '/');
    $remain = '/' . substr($uri, strlen($route) + 1);

    if ( array_key_exists($route, $this->modules) ) {
      $module = $this->modules[$route];
      $class = $module->controller;
      $controller = new $class($module->config);
      return $controller->render($remain, $method, $request);
    } else {
      return false;
    }
  }
}
