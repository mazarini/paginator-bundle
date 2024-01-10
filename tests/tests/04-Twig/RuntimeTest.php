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
use Mazarini\PaginatorBundle\Pager\Pager;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Mazarini\PaginatorBundle\Twig\Runtime\PageExtensionRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RuntimeTest extends KernelTestCase
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

    public function testClass(): void
    {
        $pages = $this->getPager(1)
            ->setLastPage(10);
        $this->assertCount(7, $pages);
        $runtime = new PageExtensionRuntime('common', 'current', 'disable');

        $this->assertInstanceOf(FirstPage::class, $pages[0]);
        $this->assertSame('common disable', $runtime->getPageClass($pages[0]));
        $this->assertInstanceOf(FirstPage::class, $pages[1]);
        $this->assertSame('common disable', $runtime->getPageClass($pages[1]));
        $this->assertInstanceOf(FirstPage::class, $pages[2]);
        $this->assertSame('common current', $runtime->getPageClass($pages[2]));
        $this->assertInstanceOf(FirstPage::class, $pages[3]);
        $this->assertSame('common', $runtime->getPageClass($pages[3]));
    }

    private function getPager(int $curentPage): Pager
    {
        return $this->pagerBuilder->CreatePager($curentPage);
    }
}
