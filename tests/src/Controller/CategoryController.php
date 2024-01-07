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

use App\Repository\CategoryRepository;
use Mazarini\PaginatorBundle\Controller\PageController;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends PageController
{
    protected bool $displayOnePage = false;
    protected string $listTemplate = 'category/index.html.twig';

    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy = ['label' => 'ASC'];

    #[Route('/', name: 'app_category_page', methods: ['GET'])]
    public function index(PagerBuilder $pagerBuilder, CategoryRepository $categoryRepository): Response
    {
        return $this->pageAction($categoryRepository, $pagerBuilder);
    }

    protected function redirectToPage(int $page): RedirectResponse
    {
        return $this->redirectToRoute('app_category_page');
    }
}
