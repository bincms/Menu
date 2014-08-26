<?php

namespace Extension\Menu\Converter;

use BinCMS\Converter\ConverterEventInterface;
use BinCMS\Converter\ConverterInterface;
use BinCMS\Converter\ConverterService;
use Extension\Menu\Document\Menu;

class MenuConverter implements ConverterInterface
{
    public function convert($value, ConverterService $converterService, ConverterEventInterface $event)
    {
        return $this->convertValue($value, $converterService, $event);
    }

    private function convertValue(Menu $menu, ConverterService $converterService, ConverterEventInterface $event)
    {
        $result = [
            'id' => $menu->getId(),
            'parent' => $converterService->convert($menu->getParent()),
            'title' => $menu->getTitle(),
            'url' => $menu->getUrl(),
            'position' => $menu->getPosition(),
            'paths' => $menu->getArrayPath()
        ];

        if($event->isDetailed()) {
            $result['children'] = $converterService->convert($menu->getChildren(), false);
        }

        return $result;
    }
}