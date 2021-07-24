<?php

namespace BoostBoard\Core;

use BoostBoard\Modules\RouteTable;

class TemplateRenderer
{
    private Request $request;
    private $modules = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $routeTable = new RouteTable();
        $this->modules = $routeTable($request->getPrivilege());
    }

    public function __invoke(string $template, $params): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../views');
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('modules', $this->modules);
        $twig->addGlobal('csrf_token', $this->request->getSession('csrf_token'));
        $template = $twig->load($template);
        return $template->render($params);
    }
}
