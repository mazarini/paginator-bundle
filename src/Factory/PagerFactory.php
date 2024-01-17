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

use Mazarini\PaginatorBundle\Config\PagerConfigInterface;
use Mazarini\PaginatorBundle\Pager\ConfigurablePager;
use Mazarini\PaginatorBundle\Pager\NoPagePager;
use Mazarini\PaginatorBundle\Pager\Pager;

class PagerFactory
{
    private PageFactory $pageFactory;

    public function __construct(private PagerConfigInterface $config)
    {
    }

    public function CreateNoPagePager(): NoPagePager
    {
        return new NoPagePager();
    }

    public function CreatePager(int $currentPage): Pager
    {
        return new Pager(
            $this->getPageFactory(),
            $this->config,
            $currentPage
        );
    }

    public function CreateConfigurablePager(int $currentPage): ConfigurablePager
    {
        return new ConfigurablePager(
            $this->getPageFactory(),
            $this->config,
            $currentPage
        );
    }

    private function getPageFactory(): PageFactory
    {
        if (!isset($this->pageFactory)) {
            $this->pageFactory = new PageFactory($this->config);
        }

        return $this->pageFactory;
    }
}
