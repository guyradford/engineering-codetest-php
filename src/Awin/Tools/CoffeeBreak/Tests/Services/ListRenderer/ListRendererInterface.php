<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ListRenderer;


use Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer\ItemRendererInterface;

interface ListRendererInterface
{
    public function Render(array $items, ItemRendererInterface $itemRenderer) : string;
}