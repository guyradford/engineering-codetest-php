<?php
namespace Awin\Tools\CoffeeBreak\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController
{

    protected function createResponse(Request $request, $output) : Response{

        switch ($request->headers->get('accept')){
            case "application/json":
                $responseContent = $this->getJsonForResponse($t);
                $contentType = "application/json";
                break;

            case "text/xml":
                $responseContent = $this->getXmlForResponse($t);
                $contentType = "text/xml";
                break;

            case "text/html":
                $responseContent = $this->getHtmlForResponse($t);
                $contentType = "text/html";
                break;
            default:
                throw new \Exception('Accept header type not supported.');
        }
        return new Response($responseContent, 200, ['Content-Type' => $contentType]);

    }


    private function getJsonForResponse(array $preferences)
    {
        return json_encode([
            "preferences" => array_map(
                function ($preference) {
                    return $preference->getAsArray();
                },
                $preferences
            )
        ]);
    }

    private function getXmlForResponse(array $preferences)
    {
        $preferencesNode = new \SimpleXMLElement("preferences");
        foreach ($preferences as $preference) {
            $preferencesNode->addChild($preference->getAsXmlNode());
        }

        return $preferencesNode->asXML();
    }

    private function getHtmlForResponse(array $preferences)
    {
        $html = "<ul>";
        foreach ($preferences as $preference) {
            $html .= $preference->getAsListElement();
        }
        $html .= "</ul>";
        return $html;
    }
}
