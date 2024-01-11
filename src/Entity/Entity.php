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

namespace Mazarini\PaginatorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Entity implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    /**
     * getId, return 0 if null.
     */
    public function getId(): int
    {
        return $this->id ?? 0;
    }

    /**
     * isNew, tell if entity do not exists in database.
     */
    public function isNew(): bool
    {
        return 0 === $this->getId();
    }

    public function getEntityId(): string
    {
        return sprintf('%s-%s', strtolower((new \ReflectionClass($this))->getShortName()), $this->getId());
    }
}
