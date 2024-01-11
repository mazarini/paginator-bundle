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

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use Mazarini\PaginatorBundle\Controller\PageController;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class ArticleController extends PageController
{
    protected string $listTemplate = 'article/index.html.twig';
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy = ['label' => 'ASC'];
    protected bool $displayOnePage = true;

    #[Route('/{id}/article/page-{page}.html', name: 'app_article_page', methods: ['GET'])]
    public function index(PagerBuilder $pagerBuilder, ArticleRepository $articleRepository, Category $category, int $page = null): Response
    {
        $this->parent = $category;
        if (null === $page) {
            return $this->redirectToPage(1);
        }
        $this->parent = $category;
        $this->criterias = ['Category' => $category];

        return $this->pageAction($articleRepository, $pagerBuilder, $page);
    }

    protected function redirectToPage(int $page): RedirectResponse
    {
        return $this->redirectToRoute('app_article_page', ['id' => $this->parent->getId(), 'page' => $page]);
    }
}
