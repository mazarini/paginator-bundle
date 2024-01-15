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

namespace App\Tests\Pager;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Test\PagerTrait;
use Mazarini\Entity\Test\DoctrineTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityRepositoryTest extends KernelTestCase
{
    use DoctrineTrait;
    use PagerTrait;
    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;

    public static function setUpBeforeClass(): void
    {
    }

    protected function setup(): void
    {
        $repository = $this->getEntityManager()->getRepository(Article::class);
        if ($repository instanceof ArticleRepository) {
            $this->articleRepository = $repository;
            $this->removeEntities($this->articleRepository);
        }
        $repository = $this->getEntityManager()->getRepository(Category::class);
        if ($repository instanceof CategoryRepository) {
            $this->categoryRepository = $repository;
            $this->removeEntities($this->categoryRepository);
        }
    }

    public function testSetup(): void
    {
        $this->assertIsObject($this->articleRepository);
        $this->assertIsObject($this->categoryRepository);
    }

    public function testNoData(): void
    {
        $pager = $this->getPager(1, 1);
        $articles = $this->articleRepository->getPageData($pager);
        $this->assertCount(0, $articles);
        $this->assertSame(1, $pager->getLastPage());
    }

    public function testBadCurrentPage(): void
    {
        $this->createCategory('Label');
        $pager = $this->getPager(2, 1);
        $categories = $this->articleRepository->getPageData($pager);
        $this->assertCount(0, $categories);
    }

    /**
     * @dataProvider currentProvider
     */
    public function testGetData(?int $currentPage, int $itemCount, int $firstItem, string $label): void
    {
        for ($i = 0; $i < 8; ++$i) {
            $this->createCategory(sprintf('Label %s', $i));
        }
        $pager = $this->getPager($currentPage, 10)
            ->setItemsPerPage(3)
            ->setOrderBy(['label' => 'ASC'])
        ;
        /**
         * @var Category[] $categories
         */
        $categories = $this->categoryRepository->getPageData($pager);
        $this->assertCount($itemCount, $categories);
        $this->assertSame($label, $categories[$firstItem]->getLabel());
    }

    /**
     * currentProvider.
     *
     * @return array<int,array<int,mixed>>
     */
    public function currentProvider(): array
    {
        return [
            [null, 8, 0, 'Label 0'],
            [1, 3, 0, 'Label 0'],
            [2, 3, 0, 'Label 3'],
            [3, 2, 0, 'Label 6'],
        ];
    }

    protected function createCategory(string $label): Category
    {
        $category = $this->categoryRepository->getNew()->setLabel($label);
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $category;
    }
}
