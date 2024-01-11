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

namespace App\Tests\Page;

use Mazarini\PaginatorBundle\Page\PageBuilder;
use Mazarini\PaginatorBundle\Pager\Pager;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testLabel(): void
    {
        $pageBuilder = $this->getPageBuilder();
        $this->assertSame('FIRST', $pageBuilder->CreateFirstPage()->getLabel());
        $this->assertSame('PREVIOUS', $pageBuilder->CreatePreviousPage()->getLabel());
        $this->assertSame('5', $pageBuilder->CreateNumberPage(5)->getLabel());
        $this->assertSame('NEXT', $pageBuilder->CreateNextPage()->getLabel());
        $this->assertSame('LAST', $pageBuilder->CreateLastPage()->getLabel());
    }

    public function testCurrentFirst(): void
    {
        $pager = $this->getPager(1);
        $pageBuilder = $this->getPageBuilder();

        $this->assertSame(1, $pageBuilder->CreateFirstPage()->setParent($pager)->getNumber());
        $this->assertSame(1, $pageBuilder->CreatePreviousPage()->setParent($pager)->getNumber());
        $this->assertSame(5, $pageBuilder->CreateNumberPage(5)->setParent($pager)->getNumber());
        $this->assertSame(2, $pageBuilder->CreateNextPage()->setParent($pager)->getNumber());
        $this->assertSame(7, $pageBuilder->CreateLastPage()->setParent($pager)->getNumber());

        $this->assertFalse($pageBuilder->CreateFirstPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreatePreviousPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateNumberPage(5)->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateNextPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateLastPage()->setParent($pager)->isCurrent());

        $this->assertTrue($pageBuilder->CreateFirstPage()->setParent($pager)->isDisable());
        $this->assertTrue($pageBuilder->CreatePreviousPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateNumberPage(5)->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateNextPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateLastPage()->setParent($pager)->isDisable());
    }

    public function testCurrentMiddle(): void
    {
        $pager = $this->getPager(5);
        $pageBuilder = $this->getPageBuilder();

        $this->assertSame(1, $pageBuilder->CreateFirstPage()->setParent($pager)->getNumber());
        $this->assertSame(4, $pageBuilder->CreatePreviousPage()->setParent($pager)->getNumber());
        $this->assertSame(5, $pageBuilder->CreateNumberPage(5)->setParent($pager)->getNumber());
        $this->assertSame(6, $pageBuilder->CreateNextPage()->setParent($pager)->getNumber());
        $this->assertSame(7, $pageBuilder->CreateLastPage()->setParent($pager)->getNumber());

        $this->assertFalse($pageBuilder->CreateFirstPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreatePreviousPage()->setParent($pager)->isCurrent());
        $this->assertTrue($pageBuilder->CreateNumberPage(5)->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateNextPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateLastPage()->setParent($pager)->isCurrent());

        $this->assertFalse($pageBuilder->CreateFirstPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreatePreviousPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateNumberPage(5)->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateNextPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateLastPage()->setParent($pager)->isDisable());
    }

    public function testCurrentLast(): void
    {
        $pager = $this->getPager(7);
        $pageBuilder = $this->getPageBuilder();

        $this->assertSame(1, $pageBuilder->CreateFirstPage()->setParent($pager)->getNumber());
        $this->assertSame(6, $pageBuilder->CreatePreviousPage()->setParent($pager)->getNumber());
        $this->assertSame(5, $pageBuilder->CreateNumberPage(5)->setParent($pager)->getNumber());
        $this->assertSame(7, $pageBuilder->CreateNextPage()->setParent($pager)->getNumber());
        $this->assertSame(7, $pageBuilder->CreateLastPage()->setParent($pager)->getNumber());

        $this->assertFalse($pageBuilder->CreateFirstPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreatePreviousPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateNumberPage(5)->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateNextPage()->setParent($pager)->isCurrent());
        $this->assertFalse($pageBuilder->CreateLastPage()->setParent($pager)->isCurrent());

        $this->assertFalse($pageBuilder->CreateFirstPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreatePreviousPage()->setParent($pager)->isDisable());
        $this->assertFalse($pageBuilder->CreateNumberPage(5)->setParent($pager)->isDisable());
        $this->assertTrue($pageBuilder->CreateNextPage()->setParent($pager)->isDisable());
        $this->assertTrue($pageBuilder->CreateLastPage()->setParent($pager)->isDisable());
    }

    private function getPager(int $currentPage = null): Pager
    {
        $pager = new Pager(
            $this->getPageBuilder(), // $pageBuilder,
            $currentPage,
            true,                    // $displayPreviousNext,
            true,                    // $displayOnePage,
            9,                       // $allPagesLimit,
            7,                       // $pagesNumberCount,
            3,                       // $itemsPerPage
        );

        return $pager->setlastPage(7);
    }

    private function getPageBuilder(): PageBuilder
    {
        return new PageBuilder(
            'FIRST',    // $firstPageLabel
            'PREVIOUS', // $previousPageLabel
            'NEXT',     // $nextPageLabel
            'LAST',     // $lastPageLabel
        );
    }
}
