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

use Mazarini\PaginatorBundle\Pager\PagerBuilder;
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
    public function twigFunction(PagerBuilder $pagerBuilder): Response
    {
        $currentPage = 1;
        foreach ([1, 3, 7] as $currentPage) {
            $tests[$currentPage] = $pagerBuilder->CreatePager($currentPage)
                ->setAllPagesLimit(6)
                ->setDisplayPreviousNext(true)
            ;
            $tests[$currentPage]->setCount(70);
        }
        $cases = ['first', 'previous', 1, 3, 7, 'next', 'last'];

        return $this->render('home/twig-function.html.twig', [
            'tests' => $tests,
            'cases' => $cases,
        ]);
    }

    #[Route('/pager/{page}', name: 'app_pager')]
    public function page(PagerBuilder $pagerBuilder, int $page): Response
    {
        $full = $pagerBuilder->CreatePager($page)
            ->setAllPagesLimit(10)
            ->setDisplayPreviousNext(true)
            ->setLastPage(9)
        ;
        $partial = $pagerBuilder->CreatePager($page)
            ->setAllPagesLimit(8)
            ->setLastPage(9)
        ;

        return $this->render('home/pager.html.twig', [
            'full' => $full,
            'partial' => $partial,
        ]);
    }
}
