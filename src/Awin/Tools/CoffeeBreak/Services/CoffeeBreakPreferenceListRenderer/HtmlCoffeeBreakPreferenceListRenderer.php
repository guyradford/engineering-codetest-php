<?php


namespace Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class HtmlCoffeeBreakPreferenceListRenderer implements CoffeeBreakPreferenceListRendererInterface
{

    public function render(array $items): string
    {
        $html = "<ul>";
        foreach ($items as $item) {
            $html .=  $this->renderItem($item);
        }
        $html .= "</ul>";
        return $html;
    }

    private function renderItem(CoffeeBreakPreference $item)
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