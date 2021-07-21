<?php

namespace BoostBoard\Core;

use PDO;

class AbstractController
{
    public $db;
    public $config;
    private $twig;

    /**
     * Consturctor for controller.
     *
     * The constructor to the following actinos:
     * - Prepare twig environment for further render usage.
     * - Prepare database connection if exist.
     *
     * @param string $root - The root of the module.
     */
    public function __construct(string $root)
    {
        $loader = new \Twig\Loader\FilesystemLoader($root);
        $this->twig = new \Twig\Environment($loader);
    }

    /**
     * Render the Twig template.
     *
     * @param  string $path   - The filepath of the template, root path is directory `pages`.
     * @param  Array  $params - The parameters to render the template.
     * @return string - The rendered result.
     */
    public function view(string $path, array $params = [])
    {
        $template = $this->twig->load($path);
        return $template->render($params);
    }
}
