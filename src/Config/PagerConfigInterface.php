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

namespace Mazarini\PaginatorBundle\Config;

interface PagerConfigInterface extends PageConfigInterface
{
    public function getDisplayPreviousNext(): bool;

    public function getDisplayOnePage(): bool;

    public function getAllPagesLimit(): int;

    public function getPagesNumberCount(): int;

    public function getItemsPerPage(): int;

    public function setDisplayPreviousNext(bool $value): static;

    public function setDisplayOnePage(bool $value): static;

    public function setAllPagesLimit(int $value): static;

    public function setPagesNumberCount(int $value): static;

    public function setItemsPerPage(int $value): static;
}
