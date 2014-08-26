<?php

namespace Extension\Menu\Repository\Interfaces;

use BinCMS\FilterBuilder\FilterBuilder;
use BinCMS\Pagination\PaginationDataBaseInterface;
use BinCMS\Repository\ObjectRepository;
use Gedmo\Tree\RepositoryInterface;

interface MenuRepositoryInterface extends ObjectRepository, RepositoryInterface
{
    public function findAllWithFilter($node = null, FilterBuilder $filterBuilder = null,
                                      PaginationDataBaseInterface $pagination = null, $direct = true);
} 