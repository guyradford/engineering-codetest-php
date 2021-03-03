<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer;


interface ItemRendererInterface
{
    /**
     * @param mixed $item
     * @return mixed
     */
    public function renderItem($item);
}