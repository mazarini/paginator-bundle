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
use Mazarini\PaginatorBundle\Page\FirstPage;
use Mazarini\PaginatorBundle\Page\LastPage;
use Mazarini\PaginatorBundle\Page\NextPage;
use Mazarini\PaginatorBundle\Page\NumberPage;
use Mazarini\PaginatorBundle\Page\PreviousPage;

class Pager extends PageManager
{
    public function __construct(
        private PageBuilder $pageBuilder,
        ?int $currentPage,
        bool $displayPreviousNext,
        bool $displayOnePage,
        int $allPagesLimit,
        int $pagesNumberCount,
        int $itemsPerPage
    ) {
        parent::__construct(
            $currentPage,
            $displayPreviousNext,
            $displayOnePage,
            $allPagesLimit,
            $pagesNumberCount,
            $itemsPerPage
        );
    }
    protected function buildPager(): void
    {
        if ($this->getDisplayOnePage() || 1 < $this->getLastPage()) {
            if ($this->getAllPagesLimit() > $this->getLastPage()) {
                $this[] = $this->pageBuilder->CreateFirstPage();
                if ($this->getDisplayPreviousNext()) {
                    $this[] = $this->pageBuilder->CreatePreviousPage();
                }
                $start = max(1, $this->getCurrentPage() - (int) (($this->getPagesNumberCount() - 1) / 2));
                $end = min($start + $this->getPagesNumberCount() - 1, $this->getLastPage());
                $start = max(1, $end - $this->getPagesNumberCount() + 1);
            } else {
                $start = 1;
                $end = $this->getLastPage();
            }
            for ($i = $start; $i <= $end; ++$i) {
                $this[] = $this->pageBuilder->CreateNumberPage($i);
            }
            if ($this->getAllPagesLimit() > $this->getLastPage()) {
                if ($this->getDisplayPreviousNext()) {
                    $this[] = $this->pageBuilder->CreateNextPage();
                }
                $this[] = $this->pageBuilder->CreateLastPage();
            }
        }
    }
}
