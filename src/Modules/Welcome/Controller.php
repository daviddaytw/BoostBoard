<?php
namespace BoostBoard\Modules\Welcome;

use BoostBoard\Core\BaseController;

class Controller extends BaseController
{
    public function __construct($config)
    {
        parent::__construct(__DIR__, $config);

        $this->addRoute(
            '/', function () {
                return $this->view('pages/index.twig');
            }
        );
    }
}
