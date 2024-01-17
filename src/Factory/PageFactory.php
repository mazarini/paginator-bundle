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

namespace Mazarini\PaginatorBundle\Factory;

use Mazarini\PaginatorBundle\Config\PageConfigInterface;
use Mazarini\PaginatorBundle\Page\FirstPage;
use Mazarini\PaginatorBundle\Page\LastPage;
use Mazarini\PaginatorBundle\Page\NextPage;
use Mazarini\PaginatorBundle\Page\NumberPage;
use Mazarini\PaginatorBundle\Page\PreviousPage;

class PageFactory
{
    public function __construct(private PageConfigInterface $config)
    {
    }

    public function CreateFirstPage(): FirstPage
    {
        return new FirstPage($this->config->getFirst());
    }

    public function CreatePreviousPage(): PreviousPage
    {
        return new PreviousPage($this->config->getPrevious());
    }

    public function CreateNumberPage(int $page): NumberPage
    {
        return new NumberPage($page);
    }

    public function CreateNextPage(): NextPage
    {
        return new NextPage($this->config->getNext());
    }

    public function CreateLastPage(): LastPage
    {
        return new LastPage($this->config->getlast());
    }
}
