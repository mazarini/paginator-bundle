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

namespace Mazarini\PaginatorBundle\Controller;

use Mazarini\PaginatorBundle\Entity\EntityInterface;
use Mazarini\PaginatorBundle\Pager\PageCollection;
use Mazarini\PaginatorBundle\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class PageController extends AbstractController
{
    /**
     * @var array<string,array<string,int|bool>>
     */
    private static array $pagerControllerOptions = [];
    protected ?EntityInterface $parent = null;
    protected EntityInterface $entity;

    /**
     * @var array<string,mixed>
     */
    protected array $criterias = [];
    /**
     * @var array<string,'ASC'|'DESC'>
     */
    protected array $orderBy = [];
    /**
     * @var array<string,mixed>
     */
    /**
     * @var array<string,int|bool>
     */
    protected array $pagerOptions = [];
    protected string $listTemplate;

    /**
     * pageAction.
     */
    /**
     * pageAction.
     *
     * @param ?int $currentPage
     */
    public function pageAction(PageRepository $articleRepository, int $currentPage = null): Response
    {
        if (isset(self::$pagerControllerOptions[$this::class])) {
            $this->pagerOptions = array_merge($this->pagerOptions, self::$pagerControllerOptions[$this::class]);
        }
        $pages = new PageCollection($currentPage, $this->criterias, $this->orderBy, $this->pagerOptions);
        $entities = $articleRepository->getPageData($pages);
        if (!$pages->isRequestOK()) {
            throw new NotFoundHttpException('Sorry page not existing!');
        }

        return $this->render($this->listTemplate, [
            'parent' => $this->parent,
            'pages' => $pages,
            'entities' => $entities,
        ]);
    }

    /**
     * Set the value of pagerControllerOptions.
     *
     * @param array<string,array<string,bool|int>> $pagerControllerOptions
     */
    public static function setPagerControllerOptions(array $pagerControllerOptions): void
    {
        self::$pagerControllerOptions = $pagerControllerOptions;
    }
}
