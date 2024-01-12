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
        throw new \LogicException(sprintf('method "%s" can\'t be allowed outside class "%s"', __METHOD__, static::class));
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        throw new \LogicException(sprintf('method "%s" can\'t be allowed outside class "%s"', __METHOD__, static::class));
    }

    /**
     * offSetGet.
     *
     * @param int $key
     *
     * @return AbstractPage
     */
    public function offSetGet(mixed $key): mixed
    {
        if (0 === parent::count()) {
            $this->buildPager();
        }
        $page = parent::offsetGet($key);
        if (null !== $page) {
            return $page;
        }
        throw new \LogicException(sprintf('pager has a null page for key "%s"', $key));
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

    protected function add(AbstractPage $page): void
    {
        parent::offsetSet(null, $page->setParent($this));
    }

    abstract protected function buildPager(): void;
}
