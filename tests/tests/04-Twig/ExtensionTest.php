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
use Mazarini\PaginatorBundle\Twig\Extension\PageExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ExtensionTest extends KernelTestCase
{
    public function testClass(): void
    {
        $extension = new PageExtension();
        $functions = $extension->getFunctions();
        $this->assertCount(1, $functions);
        $function = $functions[0];
        $callable = $function->getCallable();
        $this->assertIsArray($callable);
        $this->assertTrue(method_exists($callable[0], $callable[1]));
    }
}
