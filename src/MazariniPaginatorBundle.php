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

use Mazarini\PaginatorBundle\Config\Config;
use Mazarini\PaginatorBundle\Factory\PagerFactory;
use Mazarini\PaginatorBundle\Twig\Extension\PageExtension;
use Mazarini\PaginatorBundle\Twig\Runtime\PageExtensionRuntime;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class MazariniPaginatorBundle extends AbstractBundle
{
    private static Config $defaultConfig;

    /**
     * loadExtension.
     *
     * @param array<'class'|'label'|'pager',array<string,bool|int|string>> $configArray
     */
    public function loadExtension(array $configArray, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $config = new Config($configArray);
        $services = $containerConfigurator->services();

        $services->defaults()
            ->autowire()
            ->autoconfigure()
        ;
        $services->set(PageExtensionRuntime::class)
            ->arg('$config', $config)
            ->tag('twig.runtime')
            ->public()
        ;
        $services->set(PageExtension::class)
            ->tag('twig.extension')
            ->public()
        ;

        $services->set(PagerFactory::class)
            ->arg('$config', $config)
            ->public()
        ;
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $this->defaultConfig = new Config([]);
        // if the configuration is short, consider adding it in this class
        $definition->rootNode()
            ->children()
            ->arrayNode('pager')
            ->children()
            ->booleanNode('display_previous_next')->defaultValue(self::$defaultConfig->getDisplayPreviousNext())->end()
            ->booleanNode('display_one_page')->defaultValue(self::$defaultConfig->getDisplayOnePage())->end()
            ->integerNode('all_pages_limit')->defaultValue(self::$defaultConfig->getAllPagesLimit())->end()
            ->integerNode('pages_number_count')->defaultValue(self::$defaultConfig->getPagesNumberCount())->end()
            ->integerNode('per_page')->defaultValue(self::$defaultConfig->getItemsPerPage())->end()
            ->end()
            ->end()
            ->arrayNode('class')
            ->children()
            ->scalarNode('common')->defaultValue(self::$defaultConfig->getCommon())->end()
            ->scalarNode('current')->defaultValue(self::$defaultConfig->getActive())->end()
            ->scalarNode('disable')->defaultValue(self::$defaultConfig->getDisable())->end()
            ->end()
            ->end()
            ->arrayNode('label')
            ->children()
            ->scalarNode('first')->defaultValue(self::$defaultConfig->getFirst())->end()
            ->scalarNode('previous')->defaultValue(self::$defaultConfig->getPrevious())->end()
            ->scalarNode('next')->defaultValue(self::$defaultConfig->getNext())->end()
            ->scalarNode('last')->defaultValue(self::$defaultConfig->getlast())->end()
            ->end()
            ->end()
            ->end()
        ;
    }

    public static function getConfig(): Config
    {
        return self::$defaultConfig;
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
