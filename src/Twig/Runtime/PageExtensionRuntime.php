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

namespace Mazarini\PaginatorBundle\Twig\Runtime;

use Mazarini\PaginatorBundle\Pager\PageCollection;
use Twig\Extension\RuntimeExtensionInterface;

class PageExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function getPageClass(PageCollection $pages, int|string $page): string
    {
        switch (true) {
            case 'first' === $page:
                return '';
            case 'last' === $page:
                return '';
            case $page === $pages->getCurrentPage():
                return ' active';
            default:
                return '';
        }
    }

    public function getPageLabel(int|string $page, string $first, string $last): string
    {
        switch (true) {
            case 'first' === $page:
                return $first;
            case 'last' === $page:
                return $last;
            default:
                return (string) $page;
        }
    }

    public function getPageNumber(PageCollection $pages, int|string $page): int
    {
        switch (true) {
            case 'first' === $page:
                return 1;
            case 'last' === $page:
                return $pages->getLastpage();
            default:
                return (int) $page;
        }
    }
}
