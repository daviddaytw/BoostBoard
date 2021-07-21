<?php

namespace BoostBoard\Core;

use BoostBoard\Modules\RouteTable;

class TemplateRenderer
{
    private $modules = [];

    public function __construct(int $privilege)
    {
        $routeTable = new RouteTable();
        $this->modules = $routeTable($privilege);
    }

    public function __invoke(string $template, $params): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('modules', $this->modules);
        $template = $twig->load($template);
        return $template->render($params);
    }
}
