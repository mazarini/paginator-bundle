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

use Mazarini\PaginatorBundle\Page\FirstPage;
use Mazarini\PaginatorBundle\Page\LastPage;
use Mazarini\PaginatorBundle\Page\NextPage;
use Mazarini\PaginatorBundle\Page\NumberPage;
use Mazarini\PaginatorBundle\Page\PreviousPage;
use Mazarini\PaginatorBundle\Pager\Pager;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PagerTest extends KernelTestCase
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

    public function testCount(): void
    {
        $pages = $this->getPager(1, 1);
        $pages->setDisplayOnePage(false);
        $this->assertCount(1, $pages);

        $pages = $this->getPager(1, 1);
        $this->assertCount(1, $pages);

        $pages = $this->getPager(1, 2);
        $this->assertCount(2, $pages);

        $pages = $this->getPager(1, 5);
        $this->assertCount(5, $pages);

        $pages = $this->getPager(1, 6);
        $pages->setDisplayPreviousNext(false);
        $this->assertCount(5, $pages);

        $pages = $this->getPager(1, 6);
        $this->assertCount(7, $pages);
    }

    public function testAllPages(): void
    {
        $pages = $this->getPager(1, 5);
        $this->assertCount(5, $pages);
        $this->assertInstanceOf(NumberPage::class, $pages[0]);
        $this->assertInstanceOf(NumberPage::class, $pages[4]);
    }

    public function testNavPages(): void
    {
        $pages = $this->getPager(1, 6);
        $this->assertCount(7, $pages);
        $this->assertInstanceOf(FirstPage::class, $pages[0]);
        $this->assertInstanceOf(PreviousPage::class, $pages[1]);
        $this->assertInstanceOf(NumberPage::class, $pages[2]);
        $this->assertInstanceOf(NextPage::class, $pages[5]);
        $this->assertInstanceOf(LastPage::class, $pages[6]);
    }

    private function getPager(int $curentPage, int $lastPage): Pager
    {
        return $this->pagerBuilder->CreatePager($curentPage)
            ->setDisplayOnePage(true)
            ->setPagesNumberCount(3)
            ->setAllPagesLimit(5)
            ->setDisplayPreviousNext(true)
            ->setLastPage($lastPage)
        ;
    }
}
