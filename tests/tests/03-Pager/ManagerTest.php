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

namespace App\Tests\Pager;

use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ManagerTest extends KernelTestCase
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

    public function testNullCurrent(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $this->assertSame(1, $pages->getLastPage());
        $this->assertFalse($pages->isPagesDisplay());
        $this->assertSame(1, $pages->getLastPage());

        $pages
            ->setLastPage(2)
            ->setDisplayOnePage(true)
        ;
        $this->assertSame(1, $pages->getLastPage());
        $this->assertTrue($pages->isPagesDisplay());
    }

    public function testCount(): void
    {
        $pages = $this->pagerBuilder->createPager(3);
        $this->assertSame(10, $pages->getItemsPerPage());

        $pages->setCount(20);
        $this->assertSame(2, $pages->getLastPage());
        $this->assertFalse($pages->isPageCurrentOK());

        $pages->setCount(21);
        $this->assertSame(3, $pages->getLastPage());
        $this->assertTrue($pages->isPageCurrentOK());
    }

    public function testRequest(): void
    {
        $pages = $this->pagerBuilder->createPager();
        $pages->setCriterias(['id' => '1']);
        $pages->setOrderBy(['id' => 'ASC']);
        $this->assertSame(10, $pages->getItemsPerPage());
        $this->assertSame(['id' => '1'], $pages->getCriterias());
        $this->assertSame(['id' => 'ASC'], $pages->getOrderBy());
        $this->assertSame(0, $pages->getOffset());
        $this->assertNull($pages->getLimit());

        $pages = $this->pagerBuilder->createPager(1);
        $pages->setLastPage(1);
        $this->assertSame(0, $pages->getOffset());
        $this->assertNull($pages->getLimit());
        $pages->setLastPage(2);
        $this->assertSame(0, $pages->getOffset());
        $this->assertSame(10, $pages->getLimit());

        $pages = $this->pagerBuilder->createPager(3);
        $pages->setLastPage(3);
        $this->assertSame(20, $pages->getOffset());
        $this->assertSame(10, $pages->getLimit());
    }
}
