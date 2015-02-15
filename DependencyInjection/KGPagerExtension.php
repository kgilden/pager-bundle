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

        $this->enablePagersForInstalledPackages($container);
    }

    private function enablePagersForInstalledPackages(ContainerBuilder $container)
    {
        // A map of pagers and the classes which must exist for the pagers to
        // get enabled, null means that no classes are required (i.e. always enabled).
        $pagers = array(
            'kg_pager.doctrine_orm' => 'Doctrine\ORM\QueryBuilder',
            'kg_pager.doctrine_dbal_qb' => 'Doctrine\DBAL\Query\QueryBuilder',
            'kg_pager.fos_elastica' => 'FOS\ElasticaBundle\FOSElasticaBundle',
            'kg_pager.array' => null,
        );

        $enabledPagers = array();

        foreach ($pagers as $pager => $requiredClass) {
            if (!$requiredClass || class_exists($requiredClass)) {
                $enabledPagers[] = $container->getDefinition($pager);
            } else {
                $container->removeDefinition($pager);
            }
        }

        $container
            ->getDefinition('kg_pager')
            ->addArgument($enabledPagers)
        ;
    }
}
