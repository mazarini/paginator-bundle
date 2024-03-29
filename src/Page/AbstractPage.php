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

namespace Mazarini\PaginatorBundle\Page;

use Mazarini\PaginatorBundle\Pager\PageCollectionInterface;

abstract class AbstractPage
{
    private PageCollectionInterface $parent;

    abstract public function getNumber(): int;

    abstract public function getLabel(): string;

    abstract public function isCurrent(): bool;

    abstract public function isDisable(): bool;

    protected function getParent(): PageCollectionInterface
    {
        return $this->parent;
    }

    public function setParent(PageCollectionInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }
}
