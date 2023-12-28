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

class Request extends Config
{
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    private array $orderBy = [];
    /**
     * @var array<string,mixed>
     */
    private array $criterias = [];
    protected ?int $currentPage = null;
    private int $totalCount;

    /**
     * __construct.
     *
     * @param array<string,mixed>        $criterias
     * @param array<string,'ASC'|'DESC'> $orderBy
     * @param array<string, bool|int>    $options
     *
     * @return void
     */
    public function __construct(int $currentPage = null, array $criterias = [], array $orderBy = [], array $options = [])
    {
        $this->currentPage = $currentPage;
        $this->$criterias = $criterias;
        $this->$orderBy = $orderBy;
        parent::__construct($options);
    }

    /**
     * Get the value of orderBy.
     */
    /**
     * getOrderBy.
     *
     * @return array<string,'ASC'|'DESC'>
     */
    public function getOrderBy(): ?array
    {
        return $this->orderBy;
    }

    /**
     * getCriterias.
     *
     * @return array<string,mixed>
     */
    public function getCriterias(): array
    {
        return $this->criterias;
    }

    public function setCount(int $count): void
    {
        $this->totalCount = $count;
    }

    public function getOffset(): ?int
    {
        if (null === $this->currentPage) {
            return 0;
        }

        return ($this->currentPage - 1) * $this->getPerPage();
    }

    public function getLimit(): ?int
    {
        if (null === $this->currentPage) {
            return null;
        }

        return $this->getPerPage();
    }

    public function isRequestOK(): bool
    {
        if (null === $this->currentPage) {
            return true;
        }

        return $this->getOffset() < $this->totalCount;
    }

    protected function getCount(): int
    {
        return $this->totalCount;
    }
}
