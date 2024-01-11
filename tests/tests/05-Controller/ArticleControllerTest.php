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

namespace App\Test\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ObjectManager $manager;
    private ArticleRepository $repository;
    private Category $category;
    private string $path = '/category';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $doctrine = static::getContainer()->get('doctrine');
        if ($doctrine instanceof Registry) {
            $this->manager = $doctrine->getManager();

            $repository = $this->manager->getRepository(Category::class);
            if ($repository instanceof CategoryRepository) {
                foreach ($repository->findAll() as $object) {
                    $this->manager->remove($object);
                }
                $this->category = new Category();
                $this->manager->persist($this->category->setLabel('Label category'));
            }

            $repository = $this->manager->getRepository(Article::class);
            if ($repository instanceof ArticleRepository) {
                $this->repository = $repository;
                foreach ($this->repository->findAll() as $object) {
                    $this->manager->remove($object);
                }
            }
            $this->manager->flush();
        }
    }

    public function testNoArticle(): void
    {
        $url = $this->path.'/'.$this->category->getId().'/article/page-1.html';
        $crawler = $this->client->request('GET', $url);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Article index');
        self::assertStringContainsString('Article of '.$this->category->getLabel(), $crawler->filter('h1')->text());
        self::assertStringContainsString('no records found', $crawler->filter('body')->text());
    }

    public function testIndex(): void
    {
        $article = (new Article())
            ->setCategory($this->category)
            ->setLabel('Label category')
        ;
        $this->manager->persist($article);
        $this->manager->flush();

        $crawler = $this->client->request('GET', $this->path.'/'.$this->category->getId().'/article/page-1.html');
        self::assertResponseStatusCodeSame(200);
        self::assertSelectorExists('#'.$article->getEntityId());
        self::assertSelectorExists('li.page-item.active');

        $crawler = $this->client->request('GET', $this->path.'/'.$this->category->getId().'/article/page-2.html');
        self::assertResponseRedirects($this->path.'/'.$this->category->getId().'/article/page-1.html', 302);
    }
}
