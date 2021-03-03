<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class CoffeeBreakPreferenceHtmlItemRenderer implements CoffeeBreakPreferenceItemRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderItem(CoffeeBreakPreference $item)
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
}