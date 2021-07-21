<?php

namespace BoostBoard\Modules\Welcome;

use PDO;
use BoostBoard\Core\AbstractController;

class Controller extends AbstractController
{
    public function index(PDO $db): string
    {
        $userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $sessionCount = $db->query("SELECT COUNT(*) FROM sessions WHERE createAt >= datetime('now','-24 hours')")
                        ->fetchColumn();

        return $this->view('views/index.twig', [
            'userCount' => $userCount,
            'sessionCount' => $sessionCount,
        ]);
    }
}
