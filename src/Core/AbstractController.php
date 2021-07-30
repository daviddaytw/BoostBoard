<?php

namespace BoostBoard\Core;

use BoostBoard\Core\TemplateRenderer;

class AbstractController
{
    private Request $req;
    private Response $res;
    /**
     * Consturctor for controller.
     *
     * @param Request $req - The request object.
     * @param Response $res - The response object.
     */
    public function __construct(Request $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;
    }

    /**
     * Render the Twig template.
     *
     * @param  string $path   - The filepath of the template, root path is directory `pages`.
     * @param  array  $params - The parameters to render the template.
     * @return Response - The response contain rendered result.
     */
    public function view(string $path, array $params = []): Response
    {
        $renderer = new TemplateRenderer($this->req);
        $this->res->setPayload($renderer($path, $params));
        return $this->res;
    }
}
