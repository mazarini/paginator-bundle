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
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ObjectManager;
use Mazarini\PaginatorBundle\Page\PageBuilder;
use Mazarini\PaginatorBundle\Pager\Pager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityRepositoryTest extends KernelTestCase
{
    protected static ObjectManager $entityManager;
    protected static ArticleRepository $articleRepository;
    protected static CategoryRepository $categoryRepository;

    public static function setUpBeforeClass(): void
    {
        $kernel = self::bootKernel();
        $doctrine = $kernel->getContainer()->get('doctrine');
        if ($doctrine instanceof Registry) {
            static::$entityManager = $doctrine->getManager();
            $repository = static::$entityManager->getRepository(Article::class);
            if ($repository instanceof ArticleRepository) {
                static::$articleRepository = $repository;
            }
            $repository = static::$entityManager->getRepository(Category::class);
            if ($repository instanceof CategoryRepository) {
                static::$categoryRepository = $repository;
            }
        }
    }

    protected function setup(): void
    {
        $articles = static::$articleRepository->findAll();
        foreach ($articles as $article) {
            static::$entityManager->remove($article);
        }
        static::$entityManager->flush();
        $categories = static::$categoryRepository->findAll();
        foreach ($categories as $category) {
            static::$entityManager->remove($category);
        }
        static::$entityManager->flush();
    }

    public function testSetup(): void
    {
        $this->assertIsObject(static::$entityManager);
        $this->assertIsObject(static::$articleRepository);
        $this->assertIsObject(static::$categoryRepository);
    }

    public function testGetNew(): void
    {
        $article = static::$articleRepository->getNew();
        $this->assertInstanceOf(Article::class, $article);
    }

    public function testNoData(): void
    {
        $pager = $this->getPager(1);
        $articles = static::$articleRepository->getPageData($pager);
        $this->assertCount(0, $articles);
        $this->assertSame(1, $pager->getLastPage());
    }

    public function testBadCurrentPage(): void
    {
        $pager = $this->getPager(2);
        $category = static::$categoryRepository->getNew()->setLabel('Label');
        static::$entityManager->persist($category);
        static::$entityManager->flush();
        $categories = static::$articleRepository->getPageData($pager);
        $this->assertCount(0, $categories);
    }

    public function testGetData(): void
    {
        $categories = static::$categoryRepository->findAll();
        $this->assertCount(0, $categories);
        for ($i = 0; $i < 8; ++$i) {
            $category = static::$categoryRepository->getNew()->setLabel('Label');
            static::$entityManager->persist($category);
        }
        static::$entityManager->flush();
        $categories = static::$categoryRepository->findAll();
        $this->assertCount(8, $categories);

        $pager = $this->getPager(null);
        $categories = static::$categoryRepository->getPageData($pager);
        $this->assertCount(8, $categories);
        $id5 = $categories[5]->getId();
        $id7 = $categories[7]->getId();

        $pager = $this->getPager(2);
        $categories = static::$categoryRepository->getPageData($pager);
        $this->assertCount(3, $categories);
        $this->assertSame($id5, $categories[2]->getId());

        $pager = $this->getPager(3);
        $categories = static::$categoryRepository->getPageData($pager);
        $this->assertCount(2, $categories);
        $this->assertSame($id7, $categories[1]->getId());
    }

    private function getPager(int $currentPage = null): Pager
    {
        $pager = new Pager(
            $this->getPageBuilder(), // $pageBuilder,
            $currentPage,
            true,                    // $displayPreviousNext,
            true,                    // $displayOnePage,
            9,                       // $allPagesLimit,
            7,                       // $pagesNumberCount,
            3,                       // $itemsPerPage
        );

        return $pager->setOrderBy(['id' => 'ASC']);
    }

    private function getPageBuilder(): PageBuilder
    {
        return new PageBuilder(
            'FIRST',    // $firstPageLabel
            'PREVIOUS', // $previousPageLabel
            'NEXT',     // $nextPageLabel
            'LAST',     // $lastPageLabel
        );
    }
}
