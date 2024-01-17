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

use App\Test\PagerTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PageTest extends KernelTestCase
{
    use PagerTrait;

    public function testLabel(): void
    {
        $pager = $this->getPager(5, 10);

        $this->assertSame($this->getFirst(), $pager[0]->getLabel());
        $this->assertSame($this->getPrevious(), $pager[1]->getLabel());
        $this->assertSame('5', $pager[3]->getLabel());
        $this->assertSame($this->getNext(), $pager[5]->getLabel());
        $this->assertSame($this->getlast(), $pager[6]->getLabel());
    }

    public function testCurrentFirst(): void
    {
        $pager = $this->getPager(1, 10);

        $this->assertSame(1, $pager[0]->getNumber());
        $this->assertSame(1, $pager[1]->getNumber());
        $this->assertSame(1, $pager[2]->getNumber());
        $this->assertSame(2, $pager[3]->getNumber());
        $this->assertSame(3, $pager[4]->getNumber());
        $this->assertSame(2, $pager[5]->getNumber());
        $this->assertSame(10, $pager[6]->getNumber());

        $this->assertFalse($pager[0]->isCurrent());
        $this->assertFalse($pager[1]->isCurrent());
        $this->assertTrue($pager[2]->isCurrent());
        $this->assertFalse($pager[3]->isCurrent());
        $this->assertFalse($pager[4]->isCurrent());
        $this->assertFalse($pager[5]->isCurrent());
        $this->assertFalse($pager[6]->isCurrent());

        $this->assertTrue($pager[0]->isDisable());
        $this->assertTrue($pager[1]->isDisable());
        $this->assertFalse($pager[2]->isDisable());
        $this->assertFalse($pager[3]->isDisable());
        $this->assertFalse($pager[4]->isDisable());
        $this->assertFalse($pager[5]->isDisable());
        $this->assertFalse($pager[6]->isDisable());
    }

    public function testCurrentMiddle(): void
    {
        $pager = $this->getPager(5, 10);

        $this->assertSame(1, $pager[0]->getNumber());
        $this->assertSame(4, $pager[1]->getNumber());
        $this->assertSame(4, $pager[2]->getNumber());
        $this->assertSame(5, $pager[3]->getNumber());
        $this->assertSame(6, $pager[4]->getNumber());
        $this->assertSame(6, $pager[5]->getNumber());
        $this->assertSame(10, $pager[6]->getNumber());

        $this->assertFalse($pager[0]->isCurrent());
        $this->assertFalse($pager[1]->isCurrent());
        $this->assertFalse($pager[2]->isCurrent());
        $this->assertTrue($pager[3]->isCurrent());
        $this->assertFalse($pager[4]->isCurrent());
        $this->assertFalse($pager[5]->isCurrent());
        $this->assertFalse($pager[6]->isCurrent());

        $this->assertFalse($pager[0]->isDisable());
        $this->assertFalse($pager[1]->isDisable());
        $this->assertFalse($pager[2]->isDisable());
        $this->assertFalse($pager[3]->isDisable());
        $this->assertFalse($pager[4]->isDisable());
        $this->assertFalse($pager[5]->isDisable());
        $this->assertFalse($pager[6]->isDisable());
    }

    public function testCurrentLast(): void
    {
        $pager = $this->getPager(10, 10);

        $this->assertSame(1, $pager[0]->getNumber());
        $this->assertSame(9, $pager[1]->getNumber());
        $this->assertSame(8, $pager[2]->getNumber());
        $this->assertSame(9, $pager[3]->getNumber());
        $this->assertSame(10, $pager[4]->getNumber());
        $this->assertSame(10, $pager[5]->getNumber());
        $this->assertSame(10, $pager[6]->getNumber());

        $this->assertFalse($pager[0]->isCurrent());
        $this->assertFalse($pager[1]->isCurrent());
        $this->assertFalse($pager[2]->isCurrent());
        $this->assertFalse($pager[3]->isCurrent());
        $this->assertTrue($pager[4]->isCurrent());
        $this->assertFalse($pager[5]->isCurrent());
        $this->assertFalse($pager[6]->isCurrent());

        $this->assertFalse($pager[0]->isDisable());
        $this->assertFalse($pager[1]->isDisable());
        $this->assertFalse($pager[2]->isDisable());
        $this->assertFalse($pager[3]->isDisable());
        $this->assertFalse($pager[4]->isDisable());
        $this->assertTrue($pager[5]->isDisable());
        $this->assertTrue($pager[6]->isDisable());
    }
}
