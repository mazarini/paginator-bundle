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

namespace Mazarini\PaginatorBundle\Page;

abstract class NavPage extends AbstractPage
{
    public function __construct(
        private string $label
    ) {
    }

    public function isCurrent(): bool
    {
        return false;
    }

    public function isDisable(): bool
    {
        return
            1 === $this->getParent()->getCurrentPage() && $this->getNumber() <= 1
            || $this->getParent()->getCurrentPage() === $this->getParent()->getLastPage() && $this->getNumber() >= $this->getParent()->getLastPage()
        ;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
