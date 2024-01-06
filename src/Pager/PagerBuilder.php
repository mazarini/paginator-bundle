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

namespace Mazarini\PaginatorBundle\Pager;

use Mazarini\PaginatorBundle\Page\PageBuilder;

class PagerBuilder
{
    public function __construct(
        private PageBuilder $pageBuilder,
        private bool $displayPreviousNext,
        private bool $displayOnePage,
        private int $allPagesLimit,
        private int $pagesNumberCount,
        private int $itemsPerPage,
    ) {
    }

    public function CreatePager(int $currentPage = null): Pager
    {
        return new Pager(
            $this->pageBuilder,
            $currentPage,
            $this->displayPreviousNext,
            $this->displayOnePage,
            $this->allPagesLimit,
            $this->pagesNumberCount,
            $this->itemsPerPage
        );
    }
}
