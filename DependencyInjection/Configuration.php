<?php

namespace KG\Bundle\PagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kg_pager');

        $rootNode
            ->fixXmlConfig('pager')
            ->children()
                ->scalarNode('default')
                    ->defaultValue('default')
                ->end()
                ->arrayNode('pagers')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->integerNode('per_page')
                                ->info('Number of items to display on a single page.')
                                ->min(1)
                                ->defaultValue(25)
                            ->end()
                            ->scalarNode('key')
                                ->info('Name of the query string parameter where the current page is inferred from.')
                                ->defaultValue('page')
                            ->end()
                            ->floatNode('merge')
                                ->info('Threshold to merge 2 last pages (<1 is per cent, >=1 means number of items).')
                                ->defaultNull()
                                ->treatNullLike(0.25)
                            ->end()
                            ->booleanNode('redirect')
                                ->info('Whether to redirect out of range requests')
                                ->defaultValue(true)
                                ->treatNullLike(true)
                            ->end()
                        ->end()
                    ->end()
                    ->defaultValue(array('default' => array(
                        'per_page' => 25,
                        'key' => 'page',
                        'redirect' => true,
                    )))
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
