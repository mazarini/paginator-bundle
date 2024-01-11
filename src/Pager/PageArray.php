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

use Mazarini\PaginatorBundle\Page\AbstractPage;

/**
 * @extends \ArrayIterator<int,AbstractPage>
 */
abstract class PageArray extends \ArrayIterator implements PageCollectionInterface
{
    public function append(mixed $value): void
    {
        parent::append($value->setParent($this));
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        parent::offsetSet($key, $value->setParent($this));
    }

    public function rewind(): void
    {
        if (0 === parent::count()) {
            $this->buildPager();
        }
        parent::rewind();
    }

    public function count(): int
    {
        if (0 === parent::count()) {
            $this->buildPager();
        }

        return parent::count();
    }

    abstract protected function buildPager(): void;
}
