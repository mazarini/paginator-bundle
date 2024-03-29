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

namespace Mazarini\PaginatorBundle\Controller;

use Mazarini\Entity\Entity\EntityInterface;
use Mazarini\MessageBundle\Controller\MessageControllerTrait;
use Mazarini\PaginatorBundle\Factory\PagerFactory;
use Mazarini\PaginatorBundle\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class PageController extends AbstractController
{
    use MessageControllerTrait;
    protected bool $displayPreviousNext;
    protected bool $displayOnePage;
    protected int $allPagesLimit;
    protected int $pagesNumberCount;
    protected int $itemsPerPage;
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy;
    /**
     * @var array<string,mixed>
     */
    protected array $criterias;
    protected EntityInterface $parent;
    protected string $listTemplate;

    public function pageAction(PageRepository $articleRepository, PagerFactory $pagerFactory, int $currentPage = null): Response
    {
        if (null === $currentPage) {
            $pages = $pagerFactory->CreateNoPagePager();
        } else {
            $pages = $pagerFactory->CreateConfigurablePager($currentPage);
            if (isset($this->displayPreviousNext)) {
                $pages->setDisplayPreviousNext($this->displayPreviousNext);
            }
            if (isset($this->displayOnePage)) {
                $pages->setDisplayOnePage($this->displayOnePage);
            }
            if (isset($this->allPagesLimit)) {
                $pages->setAllPagesLimit($this->allPagesLimit);
            }
            if (isset($this->pagesNumberCount)) {
                $pages->setPagesNumberCount($this->pagesNumberCount);
            }
            if (isset($this->itemsPerPage)) {
                $pages->setItemsPerPage($this->itemsPerPage);
            }
        }
        if (isset($this->orderBy)) {
            $pages->setOrderBy($this->orderBy);
        }
        if (isset($this->criterias)) {
            $pages->setCriterias($this->criterias);
        }

        $entities = $articleRepository->getPageData($pages);
        if (!$pages->isPageCurrentOK()) {
            $this->addFlash('info', sprintf('The page "%s" does not exist', $currentPage));

            return $this->redirectToPage(1);
        }

        return $this->render($this->listTemplate, [
            'parent' => $this->parent ?? null,
            'pages' => $pages,
            'entities' => $entities,
        ]);
    }

    abstract protected function redirectToPage(int $page): Response;
}
