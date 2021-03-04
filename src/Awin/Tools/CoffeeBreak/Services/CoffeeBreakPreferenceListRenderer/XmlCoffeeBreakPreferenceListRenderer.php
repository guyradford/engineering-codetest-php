<?php


namespace Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class XmlCoffeeBreakPreferenceListRenderer implements CoffeeBreakPreferenceListRendererInterface
{

    public function render(array $items): string
    {
        $preferencesNode = new \SimpleXMLElement("<root><preferences/></root>");
        foreach ($items as $item) {
            $preferencesNode->addChild(
                $this->renderItem($item)
            );
        }

        return $preferencesNode->asXML();
    }

    public function renderItem(CoffeeBreakPreference $item)
    {
        $xml = "<preference type='".$item->getType()."' subtype='".$item->getSubType()."'>";
        $xml .= "<requestedBy>".$item->getRequestedBy()->getName()."</requestedBy>";
        $xml .= "<details>".$item->getDetails()."</details>";
        $xml .= "</preference>";
        return $xml;
    }
}