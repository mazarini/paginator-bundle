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

namespace App\Controller;

use App\Repository\CategoryRepository;
use Mazarini\PaginatorBundle\Controller\PageController;
use Mazarini\PaginatorBundle\Factory\PagerFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category')]
class CategoryController extends PageController
{
    protected string $listTemplate = 'category/index.html.twig';

    protected bool $displayPreviousNext = true;

    protected bool $displayOnePage = false;

    protected int $allPagesLimit = 3;

    protected int $pagesNumberCount = 9;

    protected int $itemsPerPage = 10;

    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy = ['label' => 'ASC'];

    #[Route('/index.html', name: 'app_category_page', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository, PagerFactory $pagerFactory): Response
    {
        return $this->pageAction($categoryRepository, $pagerFactory);
    }

    protected function redirectToPage(int $page): RedirectResponse
    {
        return $this->redirectToRoute('app_category_page');
    }
}
