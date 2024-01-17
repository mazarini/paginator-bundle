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

namespace Mazarini\PaginatorBundle\Config;

class Config implements ClassConfigInterface, PageConfigInterface, PagerConfigInterface
{
    use ConfigTrait;
    /**
     * @var array<'pager'|'class'|'label',array<string,int|bool|string>>
     */
    protected array $config = [
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

    /**
     * __construct.
     *
     * @param array<'pager'|'class'|'label',array<string,int|bool|string>> $config
     *
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($config, $this->config);
    }

    public function getDisplayPreviousNext(): bool
    {
        return (bool) $this->config['pager']['display_previous_next'];
    }

    public function getDisplayOnePage(): bool
    {
        return (bool) $this->config['pager']['display_one_page'];
    }

    public function getAllPagesLimit(): int
    {
        return (int) $this->config['pager']['all_pages_limit'];
    }

    public function getPagesNumberCount(): int
    {
        return (int) $this->config['pager']['pages_number_count'];
    }

    public function getItemsPerPage(): int
    {
        return (int) $this->config['pager']['per_page'];
    }

    public function getCommon(): string
    {
        return (string) $this->config['class']['common'];
    }

    public function getActive(): string
    {
        return (string) $this->config['class']['common'].' '.$this->config['class']['current'];
    }

    public function getDisable(): string
    {
        return (string) $this->config['class']['common'].' '.$this->config['class']['disable'];
    }

    public function getFirst(): string
    {
        return (string) $this->config['label']['first'];
    }

    public function getPrevious(): string
    {
        return (string) $this->config['label']['previous'];
    }

    public function getNext(): string
    {
        return (string) $this->config['label']['next'];
    }

    public function getlast(): string
    {
        return (string) $this->config['label']['last'];
    }
}
