<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ListRenderer;


use Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer\ItemRendererInterface;

class XmlListRenderer implements ListRendererInterface
{

    public function Render(array $items, ItemRendererInterface $itemRenderer): string
    {
        $preferencesNode = new \SimpleXMLElement("<root><preferences/></root>");
        foreach ($items as $item) {
            $preferencesNode->addChild(
                $itemRenderer->renderItem($item)
            );
        }

        return $preferencesNode->asXML();
    }
}