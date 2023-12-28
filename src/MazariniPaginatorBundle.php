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

use Mazarini\PaginatorBundle\Controller\PageController;
use Mazarini\PaginatorBundle\Pager\Config;
use Mazarini\PaginatorBundle\Twig\Extension\PageExtension;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MazariniPaginatorBundle extends AbstractBundle
{
    /**
     * loadExtension.
     *
     * @param array<mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $defaultPaginator = $config;
        unset($defaultPaginator['controller']);
        Config::setDefaultOption($defaultPaginator);
        PageController::setPagerControllerOptions($config['controller']);
        $services = $containerConfigurator->services();
        $services->load('Mazarini\PaginatorBundle\\', __DIR__.'')
            ->exclude([
                __DIR__.'/Controller/',
                __DIR__.'/DependencyInjection/',
                __DIR__.'/Pager/',
                __DIR__.'/Entity/',
                __DIR__.'/Kernel.php',
            ]);
        $services->set(self::class)
            ->public();
        $services->set(PageExtension::class)
            ->tag('twig.extension')
            ->public();
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        // if the configuration is short, consider adding it in this class
        $definition->rootNode()
            ->children()
            ->booleanNode('display_one_page')->defaultValue(false)->end()
            ->integerNode('all_pages_limit')->defaultValue(9)->end()
            ->integerNode('pages_number_count')->defaultValue(3)->end()
            ->integerNode('per_page')->defaultValue(10)->end()
            ->arrayNode('controller')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->booleanNode('display_one_page')->end()
            ->integerNode('all_pages_limit')->end()
            ->integerNode('pages_number_count')->end()
            ->integerNode('per_page')->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
