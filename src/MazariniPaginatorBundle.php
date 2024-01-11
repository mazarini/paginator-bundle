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
     * @var array<'pager'|'class'|'label',array<string,mixed>>
     */
    private static array $defaultConfig = [
        'pager' => [
            'display_previous_next' => true,
            'display_one_page' => false,
            'all_pages_limit' => 9,
            'pages_number_count' => 3,
            'per_page' => 10,
        ],
        'class' => [
            'common' => 'page-item',
            'current' => 'active',
            'disable' => 'disabled',
        ],
        'label' => [
            'first' => '<i class="bi bi-skip-start-fill"></i>',
            'previous' => '<i class="bi bi-caret-left-fill"></i>',
            'next' => '<i class="bi bi-caret-right-fill"></i>',
            'last' => '<i class="bi bi-skip-end-fill"></i>',
        ],
    ];

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
        $config = array_merge(self::$defaultConfig, $config);
        self::$defaultConfig = $config;

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
            ->booleanNode('display_previous_next')->defaultValue(self::$defaultConfig['pager']['display_previous_next'])->end()
            ->booleanNode('display_one_page')->defaultValue(self::$defaultConfig['pager']['display_one_page'])->end()
            ->integerNode('all_pages_limit')->defaultValue(self::$defaultConfig['pager']['all_pages_limit'])->end()
            ->integerNode('pages_number_count')->defaultValue(self::$defaultConfig['pager']['pages_number_count'])->end()
            ->integerNode('per_page')->defaultValue(self::$defaultConfig['pager']['per_page'])->end()
            ->end()
            ->end()
            ->arrayNode('class')
            ->children()
            ->scalarNode('common')->defaultValue(self::$defaultConfig['class']['common'])->end()
            ->scalarNode('current')->defaultValue(self::$defaultConfig['class']['current'])->end()
            ->scalarNode('disable')->defaultValue(self::$defaultConfig['class']['disable'])->end()
            ->end()
            ->end()
            ->arrayNode('label')
            ->children()
            ->scalarNode('first')->defaultValue(self::$defaultConfig['label']['first'])->end()
            ->scalarNode('previous')->defaultValue(self::$defaultConfig['label']['previous'])->end()
            ->scalarNode('next')->defaultValue(self::$defaultConfig['label']['next'])->end()
            ->scalarNode('last')->defaultValue(self::$defaultConfig['label']['last'])->end()
            ->end()
            ->end()
            ->end()
        ;
    }

    /**
     * getConfig.
     *
     * @return array<'pager'|'class'|'label',array<string,mixed>>
     */
    public static function getConfig(): array
    {
        return self::$defaultConfig;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
