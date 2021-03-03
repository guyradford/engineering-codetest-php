<?php


namespace Awin\Tools\CoffeeBreak\Tests\Services\ItemRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

interface CoffeeBreakPreferenceItemRendererInterface //extends ItemRendererInterface
{
    /**
     * @param CoffeeBreakPreference $item
     * @return mixed
     */
    public function renderItem(CoffeeBreakPreference $item);
}