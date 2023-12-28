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

/**
 * @implements \ArrayAccess<int,string|int>
 * @implements \Iterator<int,string|int>
 */
class PageCollection extends Request implements \ArrayAccess, \Iterator, \countable
{
    /**
     * @var \ArrayIterator<int,string|int>
     */
    private \ArrayIterator $data;

    /**
     * offsetExists.
     *
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->data->offsetExists($offset);
    }

    /**
     * offsetGet.
     *
     * @param int $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->getData()->offsetGet($offset);
    }

    /**
     * offsetSet.
     *
     * @param int|null           $offset
     * @param 'first'|'last'|int $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->getData()->offsetSet($offset, $value);
    }

    /**
     * offsetUnset.
     *
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->getData()->offsetUnset($offset);
    }

    /**
     * current.
     *
     * @return int|string
     */
    public function current(): mixed
    {
        return $this->getData()->current();
    }

    public function key(): mixed
    {
        return $this->getData()->key();
    }

    public function next(): void
    {
        $this->getData()->next();
    }

    public function rewind(): void
    {
        $this->getData()->rewind();
    }

    public function valid(): bool
    {
        return $this->getData()->valid();
    }

    public function count(): int
    {
        return $this->getData()->count();
    }

    public function getCurrentPage(): int
    {
        if (null === $this->currentPage) {
            return 1;
        }

        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        if (null === $this->currentPage || 0 === $this->getCount()) {
            return 1;
        }

        return (int) ($this->getCount() + $this->getPerPage() - 1) / $this->getPerPage();
    }

    /**
     * getData.
     *
     * @return \ArrayIterator<int,string|int>
     */
    private function getData(): \ArrayIterator
    {
        if (!isset($this->data)) {
            $this->buildData();
        }

        return $this->data;
    }

    private function buildData(): void
    {
        /**
         * @var array<int,'first'|'last'|int>
         */
        $data = [];
        if ($this->isDisplayOnePage() || 1 < $this->getLastPage()) {
            if ($this->getAllPagesLimit() > $this->getLastPage()) {
                $data[] = 'first';
            }
            $start = $this->getCurrentPage() - (int) ($this->getPagesNumberCount() / 2);
            $end = min($start + $this->getPagesNumberCount(), $this->getLastPage());
            $start = max(1, $end - $this->getPagesNumberCount());
            for ($i = $start; $i <= $end; ++$i) {
                $data[] = $i;
            }
            if ($this->getAllPagesLimit() > $this->getLastPage()) {
                $data[] = 'last';
            }
        }
        $this->data = new \ArrayIterator($data);
    }
}
