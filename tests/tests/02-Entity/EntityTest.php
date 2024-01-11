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

namespace App\Tests\Entity;

use Mazarini\PaginatorBundle\Entity\Entity;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    private \ReflectionProperty $idProperty;
    private Entity $entity;

    protected function setup(): void
    {
        $reflectionClass = new \ReflectionClass(Entity::class);
        $this->idProperty = $reflectionClass->getProperty('id');
        $this->entity = new Entity();
    }

    public function testNew(): void
    {
        $this->assertTrue($this->entity->isNew());
        $this->assertSame(0, $this->entity->getId());
    }

    public function testExisting(): void
    {
        $id = 1;
        $this->setId($id);
        $this->assertFalse($this->entity->isNew());
        $this->assertSame($id, $this->entity->getId());
    }

    private function setId(int $id): void
    {
        $this->idProperty->setValue($this->entity, $id);
    }
}
