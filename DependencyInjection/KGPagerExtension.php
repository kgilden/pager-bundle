<?php

namespace KG\Bundle\PagerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KGPagerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if ($redirectKey = $config['redirect_key']) {
            $container
                ->getDefinition('kg_pager.invalid_page_redirector')
                ->addArgument($redirectKey)
            ;
        }

        if (!$config['redirect_if_out_of_range']) {
            $container->removeDefinition('kg_pager.invalid_page_redirector');
        }

        if (!class_exists('FOS\ElasticaBundle\FOSElasticaBundle')) {
            $container->removeDefinition('kg_pager.fos_elastica');
        }
    }
}
