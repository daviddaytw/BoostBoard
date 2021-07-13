<?php

namespace BoostBoard\Modules\Welcome;

use PDO;
use BoostBoard\Core\BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        parent::__construct(__DIR__);

        $this->addRoute(
            '/',
            function () {
                $userCount = $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
                $sessionCount = $this->db
                                ->query("SELECT COUNT(*) FROM sessions WHERE createAt >= datetime('now','-24 hours')")
                                ->fetchColumn();

                return $this->view('pages/index.twig', [
                    'userCount' => $userCount,
                    'sessionCount' => $sessionCount,
                ]);
            }
        );
    }
}
