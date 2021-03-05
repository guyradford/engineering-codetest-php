<?php


namespace Awin\Tools\CoffeeBreak\Controller;


use Awin\Tools\CoffeeBreak\Services\Renderer\RendererInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class ControllerAbstract
{
    /**
     * @param string $format
     * @param RendererInterface $renderer
     * @param $data
     * @return Response
     */
    protected function createResponse(string $format, RendererInterface $renderer, $data) : Response
    {

        switch ($format) {
            case "json":
                $responseContent = $renderer->renderJson($data);
                $contentType = "application/json";
                break;

            case "xml":
                $responseContent = $renderer->renderXml($data);
                $contentType = "text/xml";
                break;

            default:
                $responseContent = $renderer->renderHtml($data);
                $contentType = "text/html";
        }

        return new Response($responseContent, 200, ['Content-Type' => $contentType]);
    }
}