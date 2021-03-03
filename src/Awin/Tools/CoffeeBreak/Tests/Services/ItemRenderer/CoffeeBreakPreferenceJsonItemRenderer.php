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
        return [
            "type" => $item->getType(),
            "subType" => $item->getSubType(),
            "requestedBy" => [
                "name" => $item->getRequestedBy()->getName()
            ],
            "details" => $item->getDetails()
        ];
    }
}