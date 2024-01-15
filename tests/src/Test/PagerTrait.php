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

use Mazarini\PaginatorBundle\Pager\Pager;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;

trait PagerTrait
{
    use ConfigTrait;
    private PagerBuilder $pagerBuilder;

    protected function getPager(int $currentPage = null, int $lastPage = 1): Pager
    {
        if (!isset($this->pagerBuilder)) {
            $object = $this->getContainer()->get(PagerBuilder::class);
            if ($object instanceof PagerBuilder) {
                $this->pagerBuilder = $object;
            }
        }
        if (isset($this->pagerBuilder)) {
            return $this->pagerBuilder->CreatePager($currentPage)->setLastPage($lastPage);
        }
        throw new \LogicException(sprintf('Class "%s" not found in container', PagerBuilder::class));
    }
}
