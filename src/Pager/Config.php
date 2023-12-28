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

namespace Mazarini\PaginatorBundle\Pager;

class Config
{
    /**
     * @var array<string,int|bool>
     */
    private static array $defaultOptions = [];
    /**
     * @var array<string,int|bool>
     */
    private array $options = [];

    /**
     * __construct.
     *
     * @param array<string,int|bool> $options
     *
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($options, self::$defaultOptions);
    }

    /**
     * setDefaultOption.
     *
     * @param array <string,int|bool> $options
     */
    public static function setDefaultOption(array $options): void
    {
        self::$defaultOptions = $options;
    }

    protected function isDisplayOnePage(): bool
    {
        return true === $this->options['display_one_page'];
    }

    protected function getAllPagesLimit(): int
    {
        return (int) $this->options['all_pages_limit'];
    }

    protected function getPagesNumberCount(): int
    {
        return (int) $this->options['pages_number_count'];
    }

    protected function getPerPage(): int
    {
        return (int) $this->options['per_page'];
    }
}
