<?php

namespace BoostBoard\Core;

use BoostBoard\Core\TemplateRenderer;

class AbstractController
{
    /**
     * Consturctor for controller.
     *
     * @param Request $request - The request object.
     * @param Response &$response - The response object.
     */
    public function __construct(Request $request, Response &$response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get parameter from request.
     *
     * @param string $key - The key of the parameter.
     * @return string - The value of the parameter.
     */
    public function getParam(string $key): string
    {
        return $this->request->params[$key];
    }

    /**
     * Render the Twig template.
     *
     * @param  string $path   - The filepath of the template, root path is directory `pages`.
     * @param  array  $params - The parameters to render the template.
     * @return string - The rendered result.
     */
    public function view(string $path, array $params = []): string
    {
        $renderer = new TemplateRenderer($this->request->privilege);
        return $renderer($path, $params);
    }
}
