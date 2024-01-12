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

use App\Test\ConfigTrait;
use Mazarini\PaginatorBundle\MazariniPaginatorBundle;
use PHPUnit\Framework\TestCase;

class T1_ValueTest extends TestCase
{
    use ConfigTrait;

    /**
     * testConfigCount.
     *
     * Verify the size of config's array.
     */
    public function testConfigCount(): void
    {
        $config = MazariniPaginatorBundle::getConfig();
        $this->assertSame(\count($this->config), \count($config));
        foreach ($this->config as $key => $array) {
            $this->assertSame(\count($this->config[$key]), \count($array));
        }
    }

    /**
     * testConfigValue.
     *
     * Verify each value of config
     */
    public function testConfigValue(): void
    {
        $config = MazariniPaginatorBundle::getConfig();
        foreach ($config as $key1 => $array) {
            foreach ($array as $key2 => $value) {
                $this->assertSame($this->config[$key1][$key2], $value);
            }
        }
    }
}
