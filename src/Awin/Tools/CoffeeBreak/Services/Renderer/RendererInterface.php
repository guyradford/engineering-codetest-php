<?php


namespace Awin\Tools\CoffeeBreak\Services\Renderer;


interface RendererInterface
{
        public function renderJson($data) : string;
        public function renderHtml($data) : string;
        public function renderXml($data) : string;
}