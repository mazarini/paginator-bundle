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

interface EntityPageCollectionInterface extends PageCollectionInterface
{
    /**
     * getCriterias.
     *
     * @return array<string,mixed>
     */
    public function getCriterias(): array;

    /**
     * setCriterias.
     *
     * @param array<string,mixed> $criterias
     */
    public function setCriterias(array $criterias): static;

    /**
     * getOrderBy.
     *
     * @return array<string,'ASC'|'DESC'>
     */
    public function getOrderBy(): array;

    /**
     * setOrderBy.
     *
     * @param array<string,mixed> $orderBy
     */
    public function setOrderBy(array $orderBy): static;

    public function getOffset(): int;

    public function getLimit(): ?int;
}
