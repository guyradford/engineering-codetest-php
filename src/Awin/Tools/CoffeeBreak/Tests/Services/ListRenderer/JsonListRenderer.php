<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ListRenderer;


use Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer\ItemRendererInterface;

class JsonListRenderer implements ListRendererInterface
{

    public function Render(array $items, ItemRendererInterface $itemRenderer): string
    {
        return json_encode([
            "preferences" => array_map(
                function ($item) use ($itemRenderer) {
                    return $itemRenderer->renderItem($item);
                },
                $items
            )
        ]);
    }
}