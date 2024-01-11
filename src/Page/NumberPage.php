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

class NumberPage extends AbstractPage
{
    public function __construct(private int $number)
    {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getLabel(): string
    {
        return (string) $this->number;
    }

    public function isCurrent(): bool
    {
        return $this->number === $this->getParent()->getCurrentPage();
    }

    public function isDisable(): bool
    {
        return false;
    }
}
