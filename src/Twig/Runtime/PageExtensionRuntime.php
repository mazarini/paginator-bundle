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

namespace Mazarini\PaginatorBundle\Twig\Runtime;

use Mazarini\PaginatorBundle\Page\AbstractPage;
use Twig\Extension\RuntimeExtensionInterface;

class PageExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private string $classCommon,
        private string $classCurrent,
        private string $classDisable,
    ) {
    }

    public function getPageClass(AbstractPage $page): string
    {
        $class = $this->classCommon;

        if ($page->isCurrent()) {
            $class .= ' '.$this->classCurrent;
        }

        if ($page->isDisable()) {
            $class .= ' '.$this->classDisable;
        }

        return $class;
    }
}
