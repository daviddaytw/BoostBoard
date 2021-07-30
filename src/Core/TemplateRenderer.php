<?php

namespace BoostBoard\Core;

use BoostBoard\Modules\RouteTable;

class TemplateRenderer
{
    private Request $req;
    private $modules = [];

    public function __construct(Request $req)
    {
        $this->req = $req;
        $routeTable = new RouteTable();
        $this->modules = $routeTable($req->getPrivilege());
    }

    public function __invoke(string $template, $params): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('modules', $this->modules);
        $twig->addGlobal('csrf_token', $this->req->getSession('csrf_token'));
        $template = $twig->load($template);
        return $template->render($params);
    }
}
