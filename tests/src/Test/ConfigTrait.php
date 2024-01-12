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

namespace App\Test;

trait ConfigTrait
{
    /**
     * @var array<'pager'|'class'|'label',array<string,bool|int|string>>
     */
    private array $config = [
        'pager' => [
            'display_previous_next' => true,
            'display_one_page' => false,
            'all_pages_limit' => 9,
            'pages_number_count' => 3,
            'per_page' => 10,
        ],
        'class' => [
            'common' => 'page-item',
            'current' => 'active',
            'disable' => 'disabled',
        ],
        'label' => [
            'first' => '<i class="bi bi-skip-start-fill"></i>',
            'previous' => '<i class="bi bi-caret-left-fill"></i>',
            'next' => '<i class="bi bi-caret-right-fill"></i>',
            'last' => '<i class="bi bi-skip-end-fill"></i>',
        ],
    ];

    protected function getDisplayPreviousNext(): bool
    {
        return (bool) $this->config['pager']['display_previous_next'];
    }

    protected function getDisplayOnePage(): bool
    {
        return (bool) $this->config['pager']['display_one_page'];
    }

    protected function getAllPagesLimit(): int
    {
        return (int) $this->config['pager']['all_pages_limit'];
    }

    protected function getPagesNumberCount(): int
    {
        return (int) $this->config['pager']['pages_number_count'];
    }

    protected function getItemsPerPage(): int
    {
        return (int) $this->config['pager']['per_page'];
    }

    protected function getCommon(): string
    {
        return (string) $this->config['class']['common'];
    }

    protected function getActive(): string
    {
        return (string) $this->config['class']['common'].' '.$this->config['class']['current'];
    }

    protected function getDisable(): string
    {
        return (string) $this->config['class']['common'].' '.$this->config['class']['disable'];
    }

    protected function getFirst(): string
    {
        return (string) $this->config['label']['first'];
    }

    protected function getPrevious(): string
    {
        return (string) $this->config['label']['previous'];
    }

    protected function getNext(): string
    {
        return (string) $this->config['label']['next'];
    }

    protected function getlast(): string
    {
        return (string) $this->config['label']['last'];
    }
}
