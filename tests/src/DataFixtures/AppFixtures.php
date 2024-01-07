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

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $category = new Category();
        $category->setLabel('Category 5 test tri');
        $this->manager->persist($category);
        for ($i = 1; $i < 10; ++$i) {
            $this->loadCategory($i);
        }
        $manager->flush();
    }

    private function loadCategory(int $i)
    {
        $category = new Category();
        $category->setLabel(sprintf('Category %s', $i));
        for ($j = 1; $j < 10 * $i; ++$j) {
            $this->loadArticle($category, $i, $j);
        }
        $this->manager->persist($category);
    }

    private function loadArticle(Category $category, int $i, int $j)
    {
        $article = new Article();
        $article->setLabel(sprintf('Article %s / %04s', $i, $j));
        $article->setCategory($category);
        $this->manager->persist($article);
    }
}
