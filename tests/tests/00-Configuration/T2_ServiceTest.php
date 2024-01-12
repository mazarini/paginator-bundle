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

namespace App\Tests\ConfigurationPager;

use App\Test\ContainerTrait;
use Mazarini\PaginatorBundle\Pager\Pager;
use Mazarini\PaginatorBundle\Twig\Runtime\PageExtensionRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class T2_ServiceTest extends KernelTestCase
{
    use ContainerTrait;
    private Pager $pager;
    protected PageExtensionRuntime $pageExtensionRuntime;

    protected function setup(): void
    {
        $object = $this->getContainer()->get(PageExtensionRuntime::class);
        if ($object instanceof PageExtensionRuntime) {
            $this->pageExtensionRuntime = $object;
        }
        $this->pager = $this->getPager(1, 10);
    }

    /**
     * @dataProvider pagerGetterProvider
     */
    public function testPager(string $method): void
    {
        $this->assertSame($this->$method(), $this->pager->$method());
    }

    /**
     * pagerGetterProvider.
     *
     * @return \traversable<array<string>>
     */
    public function pagerGetterProvider(): \traversable
    {
        yield ['getDisplayPreviousNext'];
        yield ['getDisplayOnePage'];
        yield ['getAllPagesLimit'];
        yield ['getPagesNumberCount'];
        yield ['getItemsPerPage'];
    }

    public function testPage(): void
    {
        $page = $this->getPager(1, 10);
        $this->assertSame($this->getFirst(), $this->pager[0]->getLabel());
        $this->assertSame($this->getPrevious(), $this->pager[1]->getLabel());
        $this->assertSame($this->getNext(), $this->pager[5]->getLabel());
        $this->assertSame($this->getLast(), $this->pager[6]->getLabel());
    }

    public function testRuntime(): void
    {
        $this->assertSame($this->getDisable(), $this->pageExtensionRuntime->getPageClass($this->pager[0]));
        $this->assertSame($this->getActive(), $this->pageExtensionRuntime->getPageClass($this->pager[2]));
        $this->assertSame($this->getCommon(), $this->pageExtensionRuntime->getPageClass($this->pager[3]));
    }
}
