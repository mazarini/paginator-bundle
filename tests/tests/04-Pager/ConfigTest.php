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

namespace App\Tests\Pager;

use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigTest extends KernelTestCase
{
    private PagerBuilder $pagerBuilder;

    protected function setup(): void
    {
        $kernel = static::bootKernel();
        $pagerBuilder = $kernel->getContainer()->get(PagerBuilder::class);
        if ($pagerBuilder instanceof PagerBuilder) {
            $this->pagerBuilder = $pagerBuilder;
        }
    }

    public function testDisplayPreviousNext(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertTrue($pages->getDisplayPreviousNext());

        $pages->setDisplayPreviousNext(false);
        $this->assertFalse($pages->getDisplayPreviousNext());
    }

    public function testDisplayOnePage(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertFalse($pages->getDisplayOnePage());

        $pages->setDisplayOnePage(true);
        $this->assertTrue($pages->getDisplayOnePage());
    }

    public function testAllPagesLimit(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertSame(9, $pages->getAllPagesLimit());

        $pages->setAllPagesLimit(3);
        $this->assertSame(3, $pages->getAllPagesLimit());
    }

    public function testPagesNumberCount(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertSame(3, $pages->getPagesNumberCount());

        $pages->setPagesNumberCount(6);
        $this->assertSame(7, $pages->getPagesNumberCount());
    }

    public function testItemsPerPage(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertSame(10, $pages->getItemsPerPage());

        $pages->setItemsPerPage(5);
        $this->assertSame(5, $pages->getItemsPerPage());
    }
}
