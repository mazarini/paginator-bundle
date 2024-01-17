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

namespace Mazarini\PaginatorBundle\Pager;

trait PagerTrait
{
    /**
     * @var array<string,mixed>
     */
    protected array $criterias = [];
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy = [];
    protected int $currentPage;
    protected int $lastPage;

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

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function setLastPage(int $lastPage): static
    {
        $this->lastPage = $lastPage;

        return $this;
    }

    public function isPagesDisplay(): bool
    {
        return false;
    }

    public function isPageCurrentOK(): bool
    {
        return $this->currentPage <= $this->lastPage;
    }
}
