<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ListRenderer;


use Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer\ItemRendererInterface;

class HtmlListRenderer implements ListRendererInterface
{

    public function Render(array $items, ItemRendererInterface $itemRenderer): string
    {
        $html = "<ul>";
        foreach ($items as $item) {
            $html .=  $itemRenderer->renderItem($item);
        }
        $html .= "</ul>";
        return $html;
    }
}