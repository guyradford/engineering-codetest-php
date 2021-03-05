<?php


namespace Awin\Tools\CoffeeBreak\Services\Renderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class PreferencesForTodayRenderer implements RendererInterface
{

    public function renderJson($data): string
    {
        return json_encode([
            "preferences" => array_map(
                function ($item) {
                    return $this->renderItemJson($item);
                },
                $data
            )
        ]);
    }

    public function renderHtml($data): string
    {
        $html = "<ul>";
        foreach ($data as $item) {
            $html .=  $this->renderItemHtml($item);
        }
        $html .= "</ul>";
        return $html;
    }

    public function renderXml($data): string
    {
        $preferencesNode = new \SimpleXMLElement("<root><preferences/></root>");
        foreach ($data as $item) {
            $preferencesNode->addChild(
                $this->renderItemXml($item)
            );
        }

        return $preferencesNode->asXML();
    }


    protected function renderItemJson(CoffeeBreakPreference $item)
    {
        return [
            "type" => $item->getType(),
            "subType" => $item->getSubType(),
            "requestedBy" => [
                "name" => $item->getRequestedBy()->getName()
            ],
            "details" => $item->getDetails()
        ];
    }

    protected function renderItemHtml(CoffeeBreakPreference $item)
    {
        $detailsString = implode(
            ",",
            array_map(
                function ($detailKey, $detailValue) {
                    return "$detailKey : $detailValue";
                },
                array_keys($item->getDetails()),
                array_values($item->getDetails())
            )
        );
        return "<li>".$item->getRequestedBy()->getName()." would like a ".$item->getSubtype()." ($detailsString)</li>";
    }

    protected function renderItemXml(CoffeeBreakPreference $item)
    {
        $xml = "<preference type='".$item->getType()."' subtype='".$item->getSubType()."'>";
        $xml .= "<requestedBy>".$item->getRequestedBy()->getName()."</requestedBy>";
        $xml .= "<details>".$item->getDetails()."</details>";
        $xml .= "</preference>";
        return $xml;
    }
}