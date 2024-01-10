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

use Mazarini\PaginatorBundle\Page\NumberPage;
use Mazarini\PaginatorBundle\Pager\Pager;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ArratTest extends KernelTestCase
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

    public function testAppend(): void
    {
        $pages = $this->getPager(1)
            ->setLastPage(9);
        $pages->append(new NumberPage(2));
        foreach ($pages as $page) {
            $this->assertSame($page->getNumber(), 2);
        }
        $this->assertCount(1, $pages);
    }

    private function getPager(int $curentPage): Pager
    {
        return $this->pagerBuilder->CreatePager($curentPage);
    }
}
