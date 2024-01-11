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

use Mazarini\PaginatorBundle\MazariniPaginatorBundle;
use Mazarini\PaginatorBundle\Page\AbstractPage;
use Mazarini\PaginatorBundle\Page\PageBuilder;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Mazarini\PaginatorBundle\Twig\Runtime\PageExtensionRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConfigurationTest extends KernelTestCase
{
    protected PagerBuilder $pagerBuilder;
    protected PageBuilder $pageBuilder;
    protected PageExtensionRuntime $pageExtensionRuntime;

    protected function setup(): void
    {
        $kernel = self::bootKernel();
        $object = $kernel->getContainer()->get(PagerBuilder::class);
        if ($object instanceof PagerBuilder) {
            $this->pagerBuilder = $object;
        }
        $object = $kernel->getContainer()->get(PageBuilder::class);
        if ($object instanceof PageBuilder) {
            $this->pageBuilder = $object;
        }
        $object = $kernel->getContainer()->get(PageExtensionRuntime::class);
        if ($object instanceof PageExtensionRuntime) {
            $this->pageExtensionRuntime = $object;
        }
    }

    public function testSetup(): void
    {
        $this->assertIsObject($this->pagerBuilder);
        $this->assertIsObject($this->pageBuilder);
        $this->assertIsObject($this->pageExtensionRuntime);
    }

    public function testPager(): void
    {
        $config = MazariniPaginatorBundle::getConfig();
        $pager = $this->pagerBuilder->CreatePager();
        $this->assertSame($config['pager']['display_previous_next'], $pager->getDisplayPreviousNext());
        $this->assertSame($config['pager']['display_one_page'], $pager->getDisplayOnePage());
        $this->assertSame($config['pager']['all_pages_limit'], $pager->getAllPagesLimit());
        $this->assertSame($config['pager']['pages_number_count'], $pager->getPagesNumberCount());
        $this->assertSame($config['pager']['per_page'], $pager->getItemsPerPage());
    }

    public function testPage(): void
    {
        $config = MazariniPaginatorBundle::getConfig();
        $this->assertSame($config['label']['first'], $this->pageBuilder->CreateFirstPage()->getLabel());
        $this->assertSame($config['label']['previous'], $this->pageBuilder->CreatePreviousPage()->getLabel());
        $this->assertSame($config['label']['next'], $this->pageBuilder->CreateNextPage()->getLabel());
        $this->assertSame($config['label']['last'], $this->pageBuilder->CreateLastPage()->getLabel());
    }

    public function testRuntime(): void
    {
        $config = MazariniPaginatorBundle::getConfig();
        $common = $config['class']['common'];
        $active = $common.' '.$config['class']['current'];
        $disable = $common.' '.$config['class']['disable'];
        $pager = $this->pagerBuilder->CreatePager(1)->setLastPage(10);
        $pager->rewind();
        $this->assertInstanceOf(AbstractPage::class, $pager[0]);
        $this->assertSame($disable, $this->pageExtensionRuntime->getPageClass($pager[0]));
        $this->assertInstanceOf(AbstractPage::class, $pager[2]);
        $this->assertSame($active, $this->pageExtensionRuntime->getPageClass($pager[2]));
        $this->assertInstanceOf(AbstractPage::class, $pager[3]);
        $this->assertSame($common, $this->pageExtensionRuntime->getPageClass($pager[3]));
    }
}
