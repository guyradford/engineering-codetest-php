<?php


namespace Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

class JsonCoffeeBreakPreferenceListRenderer implements CoffeeBreakPreferenceListRendererInterface
{

    public function render(array $items): string
    {
        return json_encode([
            "preferences" => array_map(
                function ($item) {
                    return $this->renderItem($item);
                },
                $items
            )
        ]);
    }

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