<?php

namespace Extension\Menu;

use BinCMS\ExtensionInfoInterface;

class Info implements ExtensionInfoInterface
{

    public function getVersion()
    {
        return version_compare('0', '0', '1');
    }

    public function getTitle()
    {
        return 'Меню';
    }

    public function getDependencies()
    {
        return [];
    }
}