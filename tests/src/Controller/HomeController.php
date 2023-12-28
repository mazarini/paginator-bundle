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

use Mazarini\PaginatorBundle\Pager\PageCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_twig_function');
    }

    #[Route('/twig-function', name: 'app_twig_function')]
    public function twigFunction(): Response
    {
        $currentPage = 1;
        $criterias = [];
        $orderBy = [];
        $options = [
            'display_previous_next' => false,
            'display_one_page' => false,
            'all_pages_limit' => 9,
            'pages_number_count' => 3,
            'per_page' => 10,
        ];
        foreach ([1, 3, 7] as $currentPage) {
            $tests[$currentPage] = new PageCollection($currentPage, $criterias, $orderBy, $options);
            $tests[$currentPage]->setCount(70);
        }
        $cases = ['first', 'previous', 1, 3, 7, 'next', 'last'];

        return $this->render('home/twig-function.html.twig', [
            'tests' => $tests,
            'cases' => $cases,
        ]);
    }

    #[Route('/pager/{page}', name: 'app_pager')]
    public function page(int $page): Response
    {
        $criterias = [];
        $orderBy = [];
        $options = [
            'display_previous_next' => true,
            'display_one_page' => false,
            'all_pages_limit' => 9,
            'pages_number_count' => 3,
            'per_page' => 10,
        ];
        $options['all_pages_limit'] = 10;
        $full = new PageCollection($page, $criterias, $orderBy, $options);
        $full->setCount(90);
        $options['all_pages_limit'] = 8;
        $partial = new PageCollection($page, $criterias, $orderBy, $options);
        $partial->setCount(90);

        return $this->render('home/pager.html.twig', [
            'full' => $full,
            'partial' => $partial,
        ]);
    }
}
