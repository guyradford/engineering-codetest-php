<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class CoffeeBreakPreferenceXmlItemRenderer implements CoffeeBreakPreferenceItemRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderItem(CoffeeBreakPreference $item)
    {
        $xml = "<preference type='".$item->getType()."' subtype='".$item->getSubType()."'>";
        $xml .= "<requestedBy>".$item->getRequestedBy()->getName()."</requestedBy>";
        $xml .= "<details>".$item->getDetails()."</details>";
        $xml .= "</preference>";
        return $xml;
    }
}