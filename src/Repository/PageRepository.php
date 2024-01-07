<?php

/*
 * Copyright (C) 2023 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/paginator-bundle.
 *
 * mazarini/paginator-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/paginator-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace Mazarini\PaginatorBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mazarini\PaginatorBundle\Entity\EntityInterface;
use Mazarini\PaginatorBundle\Pager\Pager;

/**
 * @extends ServiceEntityRepository<EntityInterface>
 */
abstract class PageRepository extends ServiceEntityRepository
{
    protected ManagerRegistry $registry;

    public function count(array $criteria = []): int
    {
        return parent::count($criteria);
    }

    /**
     * getNew.
     *
     * @param ?EntityInterface $parent
     */
    abstract public function getNew(mixed $parent): EntityInterface;

    /**
     * getPageData.
     *
     * @return array<entityInterface>
     */
    public function getPageData(Pager $paginator): array
    {
        $count = $this->count($paginator->getCriterias());
        $paginator->setCount($count);
        if ($count > 0 && $paginator->getLastPage() >= $paginator->getCurrentPage()) {
            return $this->findBy($paginator->getCriterias(), $paginator->getOrderBy(), $paginator->getLimit(), $paginator->getOffset());
        }

        return [];
    }
}
