<?php

namespace Fc\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fc_settings')
            ->children()
                ->booleanNode('auto_map')
                    ->isRequired()
                ->end()
                ->arrayNode('bundles')
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}