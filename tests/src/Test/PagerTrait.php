<?php

/*
 * Copyright (C) 2023-2024 Mazarini <mazarini@protonmail.com>.
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

namespace App\Test;

use Mazarini\PaginatorBundle\Factory\PagerFactory;
use Mazarini\PaginatorBundle\Pager\ConfigurablePager;
use Mazarini\PaginatorBundle\Pager\NoPagePager;
use Mazarini\PaginatorBundle\Pager\Pager;

trait PagerTrait
{
    use ConfigTrait;
    private PagerFactory $pagerFactory;

    protected function getPagerFactory(): PagerFactory
    {
        if (!isset($this->pagerFactory)) {
            $object = $this->getContainer()->get(PagerFactory::class);
            if ($object instanceof PagerFactory) {
                $this->pagerFactory = $object;
            }
        }
        if (isset($this->pagerFactory)) {
            return $this->pagerFactory;
        }
        throw new \LogicException(sprintf('Class "%s" not found in container', PagerFactory::class));
    }

    protected function getPConfigurablePager(int $currentPage, int $lastPage = 1): ConfigurablePager
    {
        return $this
            ->getPagerFactory()
            ->CreateConfigurablePager($currentPage)
            ->setLastPage($lastPage)
        ;
    }

    protected function getPager(int $currentPage, int $lastPage = 1): Pager
    {
        return $this
            ->getPagerFactory()
            ->CreatePager($currentPage)
            ->setLastPage($lastPage)
        ;
    }

    protected function getNoPagePager(): NoPagePager
    {
        return $this
            ->getPagerFactory()
            ->CreateNoPagePager()
        ;
    }
}
