<?php

namespace BoostBoard\Modules\Welcome;

use PDO;
use BoostBoard\Core\AbstractController;
use BoostBoard\Core\Request;
use BoostBoard\Core\Response;
use CpChart\Data;
use CpChart\Image;

class Controller extends AbstractController
{
    public function index(Request $req, Response $res, PDO $db): Response
    {
        $userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $sessionCount = $db->query("SELECT COUNT(*) FROM sessions WHERE createAt >= datetime('now','-24 hours')")
                        ->fetchColumn();

        return $this->view('Welcome/index.twig', [
            'userCount' => $userCount,
            'sessionCount' => $sessionCount,
        ]);
    }

    public function plotChart(Request $req, Response $res, PDO $db): Response
    {
        $rows = $db->query("SELECT COUNT(*),strftime ('%H',createAt) hour FROM sessions
                            WHERE `createAt` >= date('now', '-1 days')
                            GROUP BY strftime ('%H',createAt)");

        $actives = array_fill(0, 23, 0);
        foreach ($rows as $row) {
            $actives[(int)$row['hour']] = (int)$row['COUNT(*)'];
        }

        $data = new Data();
        $data->addPoints($actives, "New Sessions");
        $data->setAbscissa("Labels");

        $image = new Image(700, 230, $data);
        $image->setGraphArea(60, 40, 670, 190);
        $image->drawScale();
        $image->drawSplineChart();
        $image->drawLegend(600, 40, ["Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL]);
        $image->Stroke();

        $res->setPayload('');
        return $res;
    }
}
