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

namespace Mazarini\PaginatorBundle;

use Mazarini\PaginatorBundle\Page\PageBuilder;
use Mazarini\PaginatorBundle\Pager\PagerBuilder;
use Mazarini\PaginatorBundle\Twig\Extension\PageExtension;
use Mazarini\PaginatorBundle\Twig\Runtime\PageExtensionRuntime;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MazariniPaginatorBundle extends AbstractBundle
{
    /**
     * loadExtension.
     *
     * @param array<array<mixed>> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $services = $containerConfigurator->services();

        $services->defaults()
            ->autowire()
            ->autoconfigure()
        ;
        $services->set(PageExtensionRuntime::class)
            ->arg('$classCommon', $config['class']['common'])
            ->arg('$classCurrent', $config['class']['current'])
            ->arg('$classDisable', $config['class']['disable'])
            ->tag('twig.runtime')
            ->public()
        ;
        $services->set(PageExtension::class)
            ->tag('twig.extension')
            ->public()
        ;
        $services->set(PageBuilder::class)
            ->arg('$firstPageLabel', $config['label']['first'])
            ->arg('$previousPageLabel', $config['label']['previous'])
            ->arg('$nextPageLabel', $config['label']['next'])
            ->arg('$lastPageLabel', $config['label']['last'])
            ->public()
        ;

        $services->set(PagerBuilder::class)
            ->arg('$displayPreviousNext', $config['pager']['display_previous_next'])
            ->arg('$displayOnePage', $config['pager']['display_one_page'])
            ->arg('$allPagesLimit', $config['pager']['all_pages_limit'])
            ->arg('$pagesNumberCount', $config['pager']['pages_number_count'])
            ->arg('$itemsPerPage', $config['pager']['per_page'])
            ->public()
        ;
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        // if the configuration is short, consider adding it in this class
        $definition->rootNode()
            ->children()
            ->arrayNode('pager')
            ->children()
            ->booleanNode('display_previous_next')->defaultValue(false)->end()
            ->booleanNode('display_one_page')->defaultValue(false)->end()
            ->integerNode('all_pages_limit')->defaultValue(9)->end()
            ->integerNode('pages_number_count')->defaultValue(3)->end()
            ->integerNode('per_page')->defaultValue(10)->end()
            ->end()
            ->end()
            ->arrayNode('class')
            ->children()
            ->scalarNode('common')->defaultValue('page-item')->end()
            ->scalarNode('current')->defaultValue('active')->end()
            ->scalarNode('disable')->defaultValue('disabled')->end()
            ->end()
            ->end()
            ->arrayNode('label')
            ->children()
            ->scalarNode('first')->defaultValue('<i class="bi bi-skip-start-fill"></i>')->end()
            ->scalarNode('previous')->defaultValue('<i class="bi bi-caret-left-fill"></i>')->end()
            ->scalarNode('next')->defaultValue('<i class="bi bi-caret-right-fill"></i>')->end()
            ->scalarNode('last')->defaultValue('<i class="bi bi-skip-end-fill"></i>')->end()
            ->end()
            ->end()
            ->end()
        ;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
