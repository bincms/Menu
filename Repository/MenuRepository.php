<?php

namespace Extension\Menu\Repository;

use BinCMS\RepositoryTrait\RepositoryExtendTrait;
use BinCMS\RepositoryTrait\RepositoryMaterializedPathFilteredTrait;
use Extension\Menu\Repository\Interfaces\MenuRepositoryInterface;
use Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository;

class MenuRepository extends MaterializedPathRepository implements MenuRepositoryInterface
{
    use RepositoryExtendTrait;
    use RepositoryMaterializedPathFilteredTrait;
} 