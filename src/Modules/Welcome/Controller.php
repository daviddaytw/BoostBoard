<?php
namespace BoostBoard\Modules\Welcome;

use BoostBoard\Core\BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct(__DIR__);

        $this->addRoute(
            '/',
            function () {
                return $this->view('pages/index.twig');
            }
        );
    }
}
