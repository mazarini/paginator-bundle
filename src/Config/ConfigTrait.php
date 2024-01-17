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

trait ConfigTrait
{
    /**
     * @var array<'pager'|'class'|'label',array<string,int|bool|string>>
     */
    protected array $config;

    public function setDisplayPreviousNext(bool $value): static
    {
        $this->config['pager']['display_previous_next'] = $value;

        return $this;
    }

    public function setDisplayOnePage(bool $value): static
    {
        $this->config['pager']['display_one_page'] = $value;

        return $this;
    }

    public function setAllPagesLimit(int $value): static
    {
        $this->config['pager']['all_pages_limit'] = $value;

        return $this;
    }

    public function setPagesNumberCount(int $value): static
    {
        $this->config['pager']['pages_number_count'] = $value;

        return $this;
    }

    public function setItemsPerPage(int $value): static
    {
        $this->config['pager']['per_page'] = $value;

        return $this;
    }
}
