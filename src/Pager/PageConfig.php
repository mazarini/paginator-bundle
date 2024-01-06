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

abstract class PageConfig extends PageArray
{
    public function __construct(
        private bool $displayPreviousNext,
        private bool $displayOnePage,
        private int $allPagesLimit,
        private int $pagesNumberCount,
        private int $itemsPerPage
    ) {
        parent::__construct();
    }

    public function getDisplayPreviousNext(): bool
    {
        return $this->displayPreviousNext;
    }

    public function setDisplayPreviousNext(bool $displayPreviousNext): static
    {
        $this->displayPreviousNext = $displayPreviousNext;

        return $this;
    }

    public function getDisplayOnePage(): bool
    {
        return $this->displayOnePage;
    }

    public function setDisplayOnePage(bool $displayOnePage): static
    {
        $this->displayOnePage = $displayOnePage;

        return $this;
    }

    public function getAllPagesLimit(): int
    {
        return $this->allPagesLimit;
    }

    public function setAllPagesLimit(int $allPagesLimit): static
    {
        $this->allPagesLimit = $allPagesLimit;

        return $this;
    }

    public function getPagesNumberCount(): int
    {
        return $this->pagesNumberCount;
    }

    public function setPagesNumberCount(int $pagesNumberCount): static
    {
        if (0 === $pagesNumberCount % 2) {
            ++$pagesNumberCount;
        }
        $this->pagesNumberCount = $pagesNumberCount;

        return $this;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function setItemsPerPage(int $itemsPerPage): static
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }
}
