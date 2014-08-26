<?php

namespace Extension\Menu\Repository;

use BinCMS\RepositoryTrait\ExtendRepositoryTrait;
use Extension\Menu\Repository\Interfaces\MenuRepositoryInterface;
use Extension\Shop\Repository\Traits\MaterializedPathRepositoryFindAllWithFilteredMethod;
use Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository;

class MenuRepository extends MaterializedPathRepository implements MenuRepositoryInterface
{
    use ExtendRepositoryTrait;
    use MaterializedPathRepositoryFindAllWithFilteredMethod;
} 