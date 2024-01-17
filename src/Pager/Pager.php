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

use Mazarini\PaginatorBundle\Config\PagerConfigInterface;
use Mazarini\PaginatorBundle\Factory\PageFactory;

// use Mazarini\PaginatorBundle\Page\AbstractPage;

class Pager extends \AppendIterator implements EntityPageCollectionInterface
{
    use PagerTrait;
    protected PageFactory $pageFactory;
    protected PagerConfigInterface $config;
    private bool $builded = false;

    public function __construct(
        PageFactory $pageFactory,
        PagerConfigInterface $configDefault,
        int $currentPage
    ) {
        $this->pageFactory = $pageFactory;
        $this->config = clone $configDefault;
        $this->currentPage = $currentPage;
    }

    public function getOffset(): int
    {
        return 0;
    }

    public function getLimit(): ?int
    {
        return null;
    }

    public function isPagesDisplay(): bool
    {
        return false;
    }

    public function setCount(int $count): static
    {
        if (0 === $count) {
            return $this->setLastPage(1);
        }

        return $this->setLastPage((int) (($count - 1) / $this->config->getItemsPerPage()) + 1);
    }

    public function rewind(): void
    {
        $this->build();
        parent::rewind();
    }

    public function count(): int
    {
        $this->build();

        return iterator_count($this);
    }

    public function append(mixed $pages): void
    {
        throw new \RuntimeException('Method append is not allowed outside of object');
    }

    private function build(): static
    {
        if ($this->builded) {
            return $this;
        }
        $this->builded = true;
        $pages = [];
        if ($this->config->getAllPagesLimit() < $this->getLastPage()) {
            $pages[] = $this->pageFactory->CreateFirstPage();
            if ($this->config->getDisplayPreviousNext()) {
                $pages[] = $this->pageFactory->CreatePreviousPage();
            }
            $start = max(1, $this->getCurrentPage() - (int) (($this->config->getPagesNumberCount() - 1) / 2));
            $end = min($start + $this->config->getPagesNumberCount() - 1, $this->getLastPage());
            $start = max(1, $end - $this->config->getPagesNumberCount() + 1);
        } else {
            $start = 1;
            $end = $this->getLastPage();
        }
        for ($i = $start; $i <= $end; ++$i) {
            $pages[] = $this->pageFactory->CreateNumberPage($i);
        }
        if ($this->config->getAllPagesLimit() < $this->getLastPage()) {
            if ($this->config->getDisplayPreviousNext()) {
                $pages[] = $this->pageFactory->CreateNextPage();
            }
            $pages[] = $this->pageFactory->CreateLastPage();
        }
        foreach ($pages as $page) {
            $page->setParent($this);
        }
        parent::append(new \ArrayIterator($pages));

        return $this;
    }
}
