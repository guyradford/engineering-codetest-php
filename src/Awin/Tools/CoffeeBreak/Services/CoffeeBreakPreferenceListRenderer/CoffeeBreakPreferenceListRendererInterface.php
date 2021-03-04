<?php
namespace Awin\Tools\CoffeeBreak\Services\CoffeeBreakPreferenceListRenderer;


use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;

interface CoffeeBreakPreferenceListRendererInterface
{
    public function render(array $items) : string;
}