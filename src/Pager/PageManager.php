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

abstract class PageManager extends PageConfig implements PageCollectionInterface
{
    private int $lastPage;
    /**
     * @var array<string,mixed>
     */
    private array $criterias = [];
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    private array $orderBy = [];

    public function __construct(
        private ?int $currentPage,
        bool $displayPreviousNext,
        bool $displayOnePage,
        int $allPagesLimit,
        int $pagesNumberCount,
        int $itemsPerPage

    ) {
        parent::__construct(
            $displayPreviousNext,
            $displayOnePage,
            $allPagesLimit,
            $pagesNumberCount,
            $itemsPerPage
        );
    }

    /**
     * Get the value of currentPage.
     */
    public function getCurrentPage(): int
    {
        return null === $this->currentPage ? 1 : $this->currentPage;
    }

    /**
     * Get the value of lastPage.
     */
    public function getLastPage(): int
    {
        return null === $this->currentPage ? 1 : $this->lastPage;
    }

    /**
     * Set the value of lastPage.
     */
    public function setLastPage(int $lastPage): self
    {
        if (null === $this->currentPage) {
            $this->lastPage = 1;
        } else {
            $this->lastPage = $lastPage;
        }

        return $this;
    }

    /**
     * Set the value of Count.
     */
    public function setCount(int $count): self
    {
        if (0 === $count || null === $this->currentPage) {
            $this->lastPage = 1;
        } else {
            $this->lastPage = (int) (($count + $this->getItemsPerPage() - 1) / $this->getItemsPerPage());
        }

        return $this;
    }

    public function isPageCurrentOK(): bool
    {
        return $this->getCurrentPage() <= $this->getLastPage();
    }
    /**
     * Get the value of criterias.
     */
    /**
     * getCriterias.
     *
     * @return array<string,mixed>
     */
    public function getCriterias(): array
    {
        return $this->criterias;
    }

    /**
     * setCriterias.
     *
     * @param array<string,mixed> $criterias
     */
    public function setCriterias(array $criterias): static
    {
        $this->criterias = $criterias;

        return $this;
    }

    /**
     * getOrderBy.
     *
     * @return array<string,'ASC'|'DESC'>
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * setOrderBy.
     *
     * @param array<string,'ASC'|'DESC'> $orderBy
     */
    public function setOrderBy(array $orderBy): static
    {
        $this->orderBy = $orderBy;

        return $this;
    }

    public function getLimit(): ?int
    {
        return 1 === $this->getCurrentPage() ? null : $this->getItemsPerPage();
    }

    public function getOffset(): int
    {
        return ($this->getcurrentPage() - 1) * $this->getItemsPerPage();
    }
}
